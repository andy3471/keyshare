<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PlatformController extends Controller
{
    // TODO: Cache this on te model
    // TODO: Only return require attributes
    public function index(): JsonResponse
    {
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        return response()->json($platforms);
    }

    public function show(Platform $platform): JsonResponse
    {
        $games = Game::whereHas('keys', function ($query) use ($platform): void {
            $query->whereNull('owned_user_id')
                ->where('removed', '=', '0')
                ->where('platform_id', '=', $platform->id);
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
