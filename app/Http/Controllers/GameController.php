<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\GameData;
use App\DataTransferObjects\KeyData;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class GameController extends Controller
{
    public function index(Request $request): Response
    {
        $platformIds = $request->array('platforms');

        return Inertia::render('Games/Index', [
            'title' => fn () => 'Games',
            'games' => Inertia::scroll(function () use ($platformIds) {
                $games = Game::query()
                    ->whereHas('keys', function ($query) use ($platformIds): void {
                        $query->whereNull('owned_user_id')
                            ->where('removed', '=', '0');

                        if ($platformIds !== []) {
                            $query->whereIn('platform_id', $platformIds);
                        }
                    })
                    ->where('removed', '=', '0')
                    ->with('keys')
                    ->paginate(12);

                $games->through(fn ($game) => GameData::from($game)->include('hasKey', 'keyCount'));

                return $games;
            }),
            'selectedPlatforms' => fn () => $platformIds,
        ]);
    }

    public function show(Request $request, string $igdb_id): Response
    {
        $game = Game::fromIgdbId((int) $igdb_id);

        $igdbModel = IgdbGame::select([
            'name',
            'summary',
            'id',
            'parent_game',
            'aggregated_rating',
            'aggregated_rating_count',
        ])
            ->with(['cover' => ['image_id'], 'genres', 'screenshots'])
            ->where('id', '=', $game->igdb_id)
            ->first();

        $igdb = null;
        $genres = null;
        $screenshots = null;
        $parentGame = null;

        if ($igdbModel instanceof IgdbGame) {
            $igdb = [
                'aggregated_rating'       => $igdbModel->aggregated_rating,
                'aggregated_rating_count' => $igdbModel->aggregated_rating_count,
            ];
            $screenshots = $igdbModel->screenshots?->map(fn ($s): array => ['id' => $s->id, 'image_id' => $s->image_id])->toArray();
            $genres      = $igdbModel->genres?->map(fn ($g): array => ['id' => $g->id, 'name' => $g->name])->toArray();

            $parentIgdbId = null;

            // Check if parent_game exists and is not null/empty
            if (isset($igdbModel->parent_game) && $igdbModel->parent_game !== null && $igdbModel->parent_game !== '') {
                // parent_game might be an integer ID directly
                if (is_int($igdbModel->parent_game) && $igdbModel->parent_game > 0) {
                    $parentIgdbId = $igdbModel->parent_game;
                }
                // Or it might be an object with an id property
                elseif (is_object($igdbModel->parent_game) && isset($igdbModel->parent_game->id)) {
                    $parentIgdbId = $igdbModel->parent_game->id;
                }
                // Or it might be an array (if multiple parents, take first)
                elseif (is_array($igdbModel->parent_game) && count($igdbModel->parent_game) > 0) {
                    $firstParent = $igdbModel->parent_game[0];
                    $parentIgdbId = is_int($firstParent) ? $firstParent : ($firstParent->id ?? null);
                }
            }

            if ($parentIgdbId && config('igdb.enabled')) {
                $igdbParent = IgdbGame::select(['name', 'summary', 'id'])
                    ->with(['cover' => ['image_id']])
                    ->where('id', '=', $parentIgdbId)
                    ->first();

                if ($igdbParent) {
                    $parentGame = GameData::fromIgdb($igdbParent);
                }
            }

            // Get child games (DLCs) from IGDB with pagination
            // Query IGDB for games where parent_game equals this game's IGDB ID
            $childGamesPaginated = null;
            if (config('igdb.enabled')) {
                // Use a cache key based on the game's IGDB ID to avoid re-fetching on every request
                $cacheKey = 'game_dlcs_' . $game->igdb_id;

                // Fetch all DLCs from IGDB (up to limit) - cache this since it doesn't change often
                $allChildGames = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($game) {
                    return IgdbGame::select(['name', 'summary', 'id'])
                        ->with(['cover' => ['image_id']])
                        ->where('parent_game', '=', $game->igdb_id)
                        ->limit(config('igdb.per_page_limit', 500))
                        ->get();
                });

                // Create paginator manually
                // Note: InfiniteScroll with Inertia::scroll() uses the prop name to scope pagination
                // So 'childGames' scroll prop will use 'childGames_page' automatically
                $perPage = 12;
                $currentPage = (int) $request->get('childGames_page', 1);
                $total = $allChildGames->count();

                // Ensure we don't go beyond available pages
                $lastPage = (int) ceil($total / $perPage);
                $currentPage = min($currentPage, max(1, $lastPage));

                $items = $allChildGames->forPage($currentPage, $perPage)
                    ->map(fn ($igdbChild) => GameData::fromIgdb($igdbChild)->include('hasKey', 'keyCount'))
                    ->values();

                // Build query parameters, preserving existing ones
                $queryParams = $request->except('childGames_page');

                $childGamesPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $currentPage,
                    [
                        'path' => $request->url(),
                        'query' => $queryParams,
                        'pageName' => 'childGames_page',
                    ]
                );
            }
        }

        return Inertia::render('Games/Show', [
            'game'        => fn () =>GameData::fromModel($game),
            'keys'        => fn () => KeyData::collect(
                $game->keys()
                    ->select('id', 'platform_id', 'created_user_id')
                    ->whereNull('owned_user_id')
                    ->with('platform', 'createdUser')
                    ->get()
            ),
            'igdb'        => $igdb,
            'genres'      => $genres,
            'screenshots' => $screenshots,
            'parentGame' => $parentGame,
            'childGames' => $childGamesPaginated ? Inertia::scroll(fn () => $childGamesPaginated) : null,
        ]);
    }
}
