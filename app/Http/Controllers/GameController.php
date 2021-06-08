<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;
use Redirect;

class GameController extends Controller
{

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Games', [
            'url' => '/games/get',
            'title' => 'Games',
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGames()
    {
        // TODO tidy this
        $games = DB::table('games')
            ->distinct()
            ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->orderby('games.name')
            ->paginate(12);

        return $games;
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        // TODO tidy this
        $game = Game::find($id);
        $dlcCount = 0;
        $dlcurl = null;
        $igdb = null;
        $genres = null;
        $screenshots = null;
        $keys = Game::find($id)->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->where('owned_user_id', null)
            ->where('key_type_id', '1')
            ->with('platform', 'createduser')
            ->get();

        if(config('app.dlc_enabled')) {
            $dlcCount = DB::table('dlcs')
                ->distinct()
                ->selectRaw('dlcs.id, dlcs.name, concat("/", dlcs.image) as image, concat("/games/dlc/", dlcs.id) as url')
                ->join('keys', 'keys.dlc_id', '=', 'dlcs.id')
                ->where('keys.owned_user_id', '=', null)
                ->where('keys.removed', '=', '0')
                ->where('keys.game_id', '=', $id)
                ->count();
            $dlcurl = "/games/dlc/get/" . $id;
        }


        if($game->igdb_id) {
            $igdb = Igdb::select(['aggregated_rating', 'aggregated_rating_count'])->with(['genres', 'screenshots'])->where('id', '=', $game->igdb_id)->first();
            $screenshots = $igdb->screenshots;
            $genres = $igdb->genres;
        }

        return Inertia::render('Games/Show', [
            'game' => $game,
            'keys' => $keys,
            'dlcUrl' => $dlcurl,
            'dlcCount' => $dlcCount,
            'igdb' => $igdb,
            'genres' => $genres,
            'screenshots' => $screenshots,
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        // TODO tidy this
        $game = Game::find($id);
        $igdb = null;

        if($game->igdb_id && config('igdb.enabled')) {
            $igdb = Igdb::select(['name'])->where('id', '=', $game->igdb_id)->first();
        }

        return Inertia::render('Games/Edit', [
            'game' => $game,
            'igdb' => $igdb,
        ]);

        return view('games.edit')->withGame($game)->withIgdb($igdb);
    }


    /**
     * @param UpdateGameRequest $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UpdateGameRequest $request)
    {
        // TODO make this a job
        if ($request->hasFile('photo')) {
            $filename = uniqid();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = $filename . '.' . $extension;
            $folderToStore = 'images/games/';
            $fullImagePath = $folderToStore . $filenameToStore;

            $path = $request->file('photo')->storeAs('public/' . $folderToStore, $filenameToStore);
        }

        $game = Game::find($request->gameid);
        $game->name = $request->name;
        $game->description = $request->description;

        if ($request->hasFile('photo')) {
            $game->image = '/storage/' . $fullImagePath;
        }

        if ($request->igdbname) {
            $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->igdbname)->first();

            if ($igdb && (! ($igdb->id == $game->igdb_id))) {
                $game->name = $igdb->name;
                $game->description = $igdb->summary;
                $game->igdb_id = $igdb->id;
                $game->image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $igdb->cover->image_id . '.jpg';
                $game->igdb_updated = Carbon::today();
            }
        } else {
            $game->igdb_id = null;
            $game->igdb_updated = null;
        }

        $game->save();

        return Redirect::route('game.show', [$game]);
    }
}
