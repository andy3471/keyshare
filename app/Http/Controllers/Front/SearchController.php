<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController extends Controller
{
    // TODO: Refactor
    public function index(Request $request): Response|RedirectResponse
    {
        $search = $request->search;

        $game = DB::table('games')
            ->select('id')
            ->where('name', '=', $search)
            ->where('removed', '=', '0')
            ->get();

        if (count($game) === 0) {
            if (config('igdb.enabled')) {
                $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->search)->first();

                if ($igdb) {
                    $game                  = new Game;
                    $game->name            = $igdb->name;
                    $game->description     = $igdb->summary;
                    $game->igdb_id         = $igdb->id;
                    $game->image           = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                    $game->igdb_updated    = \Illuminate\Support\Facades\Date::today();
                    $game->created_user_id = auth()->user()->id;
                    $game->save();

                    return to_route('games.show', $game);
                }
            }

            $games = DB::table('games')
                ->selectRaw('games.id, games.name, CASE WHEN igdb_id IS NULL THEN concat("/", games.image) ELSE games.image END as image, concat("/games/", games.id) as url')
                ->where('name', 'like', '%'.$search.'%')
                ->where('removed', '=', '0')
                ->paginate(12);

            return Inertia::render('Search/Index', [
                'title' => $search,
                'games' => Inertia::scroll(fn () => $games),
            ]);
        }

        $gameId = $game[0]->id;

        return to_route('games.show', $gameId);
    }

    public function autoCompleteGames(Request $request)
    {
        $search = $request->input('q', '');
        
        if (config('igdb.enabled')) {
            $games = \MarcReichel\IGDBLaravel\Models\Game::select(['name', 'id'])->search($search)->limit(5)->get();
            return response()->json($games);
        }
        
        $games = DB::table('games')
            ->select('id', 'name')
            ->where('name', 'like', '%'.$search.'%')
            ->where('removed', '=', '0')
            ->limit(5)
            ->get();
            
        return response()->json($games);
    }

    public function autoCompleteDlc(Request $request, string $gamename)
    {
        $search = $request->input('q', '');
        
        $game = Game::where('name', $gamename)->first();
        
        if (!$game) {
            return response()->json([]);
        }
        
        $dlc = DB::table('dlcs')
            ->select('id', 'name')
            ->where('name', 'like', '%'.$search.'%')
            ->where('game_id', '=', $game->id)
            ->limit(5)
            ->get();
            
        return response()->json($dlc);
    }
}
