<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController
{
    public function index(Request $request): JsonResponse
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

    public function autoCompleteGames(string $search): JsonResponse
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

    // TODO: Refactor
    public function autoCompleteDlc($gamename, string $search): JsonResponse
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
