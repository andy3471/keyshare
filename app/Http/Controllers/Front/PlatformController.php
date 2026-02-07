<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\PlatformData;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlatformController extends Controller
{
    public function show(Request $request, Platform $platform): Response
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

        // Transform to include IGDB images and key availability
        $games->getCollection()->transform(function ($game) use ($platform): array {
            // Count available keys for this game on this platform
            $keyCount = $game->keys()
                ->whereNull('owned_user_id')
                ->where('removed', '=', '0')
                ->where('platform_id', '=', $platform->id)
                ->count();
            $hasKey = $keyCount > 0;
            
            return [
                'id'    => $game->id,
                'name'  => $game->name,
                'image' => $game->image,
                'url'   => route('games.show', $game->igdb_id),
                'hasKey' => $hasKey,
                'keyCount' => $keyCount,
            ];
        });

        return Inertia::render('Platforms/Show', [
            'platform' => PlatformData::fromModel($platform),
            'games'    => Inertia::scroll(fn () => $games),
        ]);
    }
}
