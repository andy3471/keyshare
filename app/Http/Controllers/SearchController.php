<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController extends Controller
{
    // TODO: Refactor
    public function search(Request $request): View|RedirectResponse
    {
        $search = $request->search;

        $game = DB::table('games')
            ->select('id')
            ->where('name', '=', $search)
            ->where('removed', '=', '0')
            ->get();

        if (count($game) == 0) {
            if (config('igdb.enabled')) {
                $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->search)->first();

                if ($igdb) {
                    $game = new Game;
                    $game->name = $igdb->name;
                    $game->description = $igdb->summary;
                    $game->igdb_id = $igdb->id;
                    $game->image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                    $game->igdb_updated = Carbon::today();
                    $game->created_user_id = Auth::id();
                    $game->save();

                    return redirect()->route('game', $game);
                }
            }

            return view('games.index')->withTitle($search)->withurl('/search/get/?search='.$search.'&');
        } else {
            $game = $game[0]->id;

            return redirect()->route('game', $game);
        }
    }

    // TODO: Refactor

    public function getSearch(Request $request): JsonResponse
    {
        $search = $request->search;

        $games = DB::table('games')
            ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
            ->where('name', 'like', '%'.$search.'%')
            ->where('removed', '=', '0')
            ->paginate(12);

        $games->appends(['search' => $search])->links();

        return response()->json($games);
    }

    //TODO: Refactor
    public function autocomplete($search): JsonResponse
    {
        if (config('igdb.enabled')) {
            $games = Igdb::select(['name', 'id'])->search($search)->get();
        } else {
            $games = DB::table('games')
                ->select('id', 'name')
                ->where('name', 'like', '%'.$search.'%')
                ->where('removed', '=', '0')
                ->limit(5)
                ->get();
        }

        return response()->json($games);
    }

    //TODO: Refactor
    public function autocompleteDlc($gamename, $search): JsonResponse
    {
        $game = Game::where('name', $gamename)
            ->firstOrFail();

        $dlc = DB::table('dlcs')
            ->select('id', 'name')
            ->where('name', 'like', '%'.$search.'%')
            ->where('game_id', '=', $game->id)
            ->limit(5)
            ->get();

        return response()->json($dlc);
    }
}
