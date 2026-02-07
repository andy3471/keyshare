<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->search;

        // Search IGDB directly since we don't store names
        if (!config('igdb.enabled')) {
            return response()->json(['error' => 'IGDB API is required but not enabled.'], 400);
        }
        
        $igdbGames = Igdb::select(['id', 'name'])
            ->where('name', 'like', '%'.$search.'%')
            ->whereNull('parent_game') // Only base games
            ->limit(12)
            ->get();
        
        // Get or create games from IGDB results
        $games = collect();
        foreach ($igdbGames as $igdbGame) {
            $game = Game::where('igdb_id', $igdbGame->id)->first();
            if (!$game) {
                // Create game if it doesn't exist
                $game = Game::createFromIgdb($igdbGame);
            }
            $games->push([
                'id' => $game->id,
                'igdb_id' => $game->igdb_id,
                'name' => $game->name,
                'image' => $game->image,
                'url' => route('games.show', $game->igdb_id),
            ]);
        }
        
        // Create a paginator-like structure
        $paginatedGames = new \Illuminate\Pagination\LengthAwarePaginator(
            $games,
            $games->count(),
            12,
            1
        );
        
        $paginatedGames->appends(['search' => $search])->links();

        return response()->json($paginatedGames);
    }

    public function autoCompleteGames(string $search): JsonResponse
    {
        // IGDB is required for autocomplete
        if (! config('igdb.enabled')) {
            return response()->json(['error' => 'IGDB API is required but not enabled.'], 400);
        }

        $games = Igdb::select(['name', 'id'])->search($search)->get();

        return response()->json($games);
    }

    public function autoCompleteDlc($gamename, string $search): JsonResponse
    {
        // Find game by searching IGDB for the name, then get its DLCs
        if (! config('igdb.enabled')) {
            return response()->json([]);
        }

        // Search IGDB for the parent game
        $igdbParent = Igdb::select(['id', 'name'])->where('name', '=', $gamename)->whereNull('parent_game')->first();

        if (! $igdbParent) {
            return response()->json([]);
        }

        // Find or create the parent game
        $game = Game::where('igdb_id', $igdbParent->id)->first();
        if (! $game) {
            $game = Game::createFromIgdb($igdbParent);
        }

        // Get DLCs from IGDB for this parent game
        $igdbDlcs = Igdb::select(['id', 'name'])
            ->where('parent_game', '=', $igdbParent->id)
            ->where('name', 'like', '%'.$search.'%')
            ->limit(5)
            ->get();

        // Return DLC data
        return response()->json($igdbDlcs->map(function ($igdbDlc): array {
            return [
                'id'   => $igdbDlc->id,
                'name' => $igdbDlc->name,
            ];
        }));
    }
}
