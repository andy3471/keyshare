<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index')->withTitle('Games')->withurl('/games/get');
    }

    public function getGames()
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw("games.id, games.name, games.image, concat('/games/', games.id) as url")
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->orderby('games.name')
            ->paginate(12);

        return $games;
    }

    public function show($id)
    {
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

        if (config('app.dlc_enabled')) {
            $dlcCount = DB::table('dlcs')
                ->distinct()
                ->selectRaw('dlcs.id, dlcs.name, concat("/", dlcs.image) as image, concat("/games/dlc/", dlcs.id) as url')
                ->join('keys', 'keys.dlc_id', '=', 'dlcs.id')
                ->where('keys.owned_user_id', '=', null)
                ->where('keys.removed', '=', '0')
                ->where('keys.game_id', '=', $id)
                ->count();
            $dlcurl = '/games/dlc/get/'.$id;
        }

        if ($game->igdb_id) {
            $igdb = Igdb::select(['aggregated_rating', 'aggregated_rating_count'])->with(['genres', 'screenshots'])->where('id', '=', $game->igdb_id)->first();
            $screenshots = $igdb->screenshots;
            $genres = $igdb->genres;
        }

        return view('games.show')
            ->withGame($game)
            ->withKeys($keys)
            ->withDlcurl($dlcurl)
            ->withDlcCount($dlcCount)
            ->withIgdb($igdb)
            ->withGenres($genres)
            ->withScreenshots($screenshots);
    }

    public function edit($id)
    {
        $game = Game::find($id);
        $igdb = null;

        if ($game->igdb_id && config('igdb.enabled')) {
            $igdb = Igdb::select(['name'])->where('id', '=', $game->igdb_id)->first();
        }

        return view('games.edit')->withGame($game)->withIgdb($igdb);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:width=264,height=352',
            'igdbname' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename.'.'.$extension;
            $folderToStore = 'images/games/';
            $fullImagePath = $folderToStore.$filenameToStore;

            $path = $request->file('image')->storeAs('public/'.$folderToStore, $filenameToStore);
        }

        $game = Game::find($request->gameid);
        $game->name = $request->name;
        $game->description = $request->description;
        if ($request->hasFile('image')) {
            $game->image = 'storage/'.$fullImagePath;
        }

        if ($request->igdbname) {
            $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->igdbname)->first();

            if ($igdb && (! ($igdb->id == $game->igdb_id))) {
                $game->name = $igdb->name;
                $game->description = $igdb->summary;
                $game->igdb_id = $igdb->id;
                $game->image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                $game->igdb_updated = Carbon::today();
            }
        } else {
            $game->igdb_id = null;
            $game->igdb_updated = null;
        }

        $game->save();

        return redirect()->route('game', ['id' => $request->gameid])->with('message', __('games.gameupdated'));
    }
}
