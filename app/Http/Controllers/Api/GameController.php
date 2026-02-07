<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        $games = Game::whereHas('keys', function ($query): void {
            $query->whereNull('owned_user_id')
                ->where('removed', '=', '0');
        })
            ->where('removed', '=', '0')
            ->paginate(12);

        // Sort by name (from IGDB) after fetching
        $games->getCollection()->sortBy(function ($game) {
            return $game->name ?? '';
        });

        // Transform to include IGDB images
        $games->getCollection()->transform(function ($game): array {
            return [
                'id'    => $game->id,
                'name'  => $game->name,
                'image' => $game->image,
                'url'   => route('games.show', $game->igdb_id),
            ];
        });

        return response()->json($games);
    }
}
