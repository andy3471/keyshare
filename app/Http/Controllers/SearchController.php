<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;
use Redirect;

class SearchController extends Controller
{
    // TODO Implement Meilisearch
    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function search(Request $request)
    {
        // TODO Tidy this
        $search = $request->search;

        $game = DB::table('games')
            ->select('id')
            ->where('name', '=', $search)
            ->where('removed', '=', '0')
            ->get();

        if (count($game) == 0) {
            if (config('igdb.enabled')) {
                $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->search)->first();

                if($igdb) {
                    $game = New Game;
                    $game->name = $igdb->name;
                    $game->description = $igdb->summary;
                    $game->igdb_id = $igdb->id;
                    $game->image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $igdb->cover->image_id . '.jpg';
                    $game->igdb_updated = Carbon::today();
                    $game->created_user_id = Auth::id();
                    $game->save();
                    return Redirect::route('game.show', $game);
                }
            }

            return Inertia::render('Games', [
                'url' => '/search/get/?search=' . $search . '&',
                'title' => $search,
            ]);

        } else {
            $game = $game[0]->id;
            return Redirect::route('game.show', $game);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch(Request $request)
    {
        // TODO tidy this - use meilisearch
        $search = $request->search;

        $games = DB::table('games')
            ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
            ->where('name', 'like', '%' . $search . '%')
            ->where('removed', '=', '0')
            ->paginate(12);

        $games->appends(['search' => $search])->links();

        return $games;
    }

    public function autocomplete($search)
    {
        if(config('igdb.enabled')) {
            $games = Igdb::select(['name', 'id'])->search($search)->get();
        } else {
            $games = DB::table('games')
                ->select('id', 'name')
                ->where('name', 'like', '%' . $search . '%')
                ->where('removed', '=', '0')
                ->limit(5)
                ->get();
        }

        return json_encode($games);
    }

    public function autocompleteDlc($gamename, $search)
    {
        $game = Game::where('name', $gamename)
            ->firstOrFail();

        $dlc = DB::table('dlcs')
            ->select('id', 'name')
            ->where('name', 'like', '%' . $search . '%')
            ->where('game_id', '=', $game->id)
            ->limit(5)
            ->get();

        return json_encode($dlc);
    }
}
