<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\GameData;
use App\DataTransferObjects\KeyData;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    public function index(Request $request): Response
    {
        // Get platform filters from request
        $platformIds = $request->input('platforms', []);
        if (is_string($platformIds)) {
            $platformIds = [$platformIds];
        }
        $platformIds = array_filter($platformIds);
        
        // Get games with available keys
        $games = Game::whereHas('keys', function ($query) use ($platformIds): void {
                $query->whereNull('owned_user_id')
                    ->where('removed', '=', '0');
                
                // Filter by platforms if provided
                if (!empty($platformIds)) {
                    $query->whereIn('platform_id', $platformIds);
                }
            })
            ->where('removed', '=', '0')
            ->with('keys')
            ->paginate(12);

        // Transform to include IGDB images and key availability
        $games->getCollection()->transform(function ($game): array {
            $image = null;
            if ($game->igdb_id && config('igdb.enabled')) {
                $igdb = $game->getIgdbData();
                if ($igdb && $igdb->cover && isset($igdb->cover->image_id)) {
                    $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                }
            }
            
            // Count available keys
            $keyCount = $game->keys()
                ->whereNull('owned_user_id')
                ->where('removed', '=', '0')
                ->count();
            $hasKey = $keyCount > 0;
            
            return [
                'id' => $game->id,
                'igdb_id' => $game->igdb_id,
                'name' => $game->name,
                'image' => $image,
                'url' => route('games.show', $game->igdb_id),
                'hasKey' => $hasKey,
                'keyCount' => $keyCount,
            ];
        });

        return Inertia::render('Games/Index', [
            'title' => 'Games',
            'games' => Inertia::scroll(fn () => $games),
            'selectedPlatforms' => $platformIds,
        ]);
    }

    public function show(Request $request, string $igdb_id): Response
    {
        // Cast to int since route parameters come as strings
        $igdb_id = (int) $igdb_id;
        
        // Find or create game from IGDB ID
        $game = Game::where('igdb_id', $igdb_id)->first();
        
        if (!$game) {
            // IGDB is required - games can only be created from IGDB
            if (!config('igdb.enabled')) {
                abort(404, 'Game not found and IGDB API is not enabled.');
            }
            
            // Fetch game from IGDB
            $igdbGame = \MarcReichel\IGDBLaravel\Models\Game::select(['name', 'summary', 'id', 'parent_game'])
                ->with(['cover' => ['image_id'], 'genres', 'screenshots'])
                ->where('id', '=', $igdb_id)
                ->first();
            
            if (!$igdbGame) {
                abort(404, 'Game not found in IGDB.');
            }
            
            // Create the game
            $game = Game::createFromIgdb($igdbGame);
        }

        // Get keys for this game
        $keys = $game->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->whereNull('owned_user_id')
            ->with('platform', 'createdUser')
            ->get()
            ->map(fn (\App\Models\Key $key): KeyData => KeyData::fromModel($key));

        // Fetch IGDB data for the main game - ensure parent_game and dlcs are loaded
        // Fetch fresh data directly from IGDB (not cached) to ensure we have parent_game
        $igdbModel = \MarcReichel\IGDBLaravel\Models\Game::select([
            'name',
            'summary',
            'id',
            'parent_game', // This is an integer ID field, not a relationship
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

        if ($igdbModel instanceof \MarcReichel\IGDBLaravel\Models\Game) {
            $igdb = [
                'aggregated_rating'       => $igdbModel->aggregated_rating,
                'aggregated_rating_count' => $igdbModel->aggregated_rating_count,
            ];
            $screenshots = $igdbModel->screenshots?->map(fn ($s): array => ['id' => $s->id, 'image_id' => $s->image_id])->toArray();
            $genres      = $igdbModel->genres?->map(fn ($g): array => ['id' => $g->id, 'name' => $g->name])->toArray();
            
            // Get parent game from IGDB (if this game has a parent)
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
                    // Fetch parent game from IGDB
                    $igdbParent = \MarcReichel\IGDBLaravel\Models\Game::select(['name', 'summary', 'id'])
                        ->with(['cover' => ['image_id']])
                        ->where('id', '=', $parentIgdbId)
                        ->first();
                    
                    if ($igdbParent) {
                        $parentImage = null;
                        if ($igdbParent->cover && isset($igdbParent->cover->image_id)) {
                            $parentImage = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbParent->cover->image_id.'.jpg';
                        }
                        
                        $parentGame = [
                            'igdb_id' => $igdbParent->id,
                            'name' => $igdbParent->name,
                            'image' => $parentImage,
                            'url' => route('games.show', $igdbParent->id),
                        ];
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
                    $igdbDlcs = \MarcReichel\IGDBLaravel\Models\Game::select(['name', 'summary', 'id'])
                        ->with(['cover' => ['image_id']])
                        ->where('parent_game', '=', $game->igdb_id)
                        ->limit(config('igdb.per_page_limit', 500))
                        ->get();
                    
                    // Transform to game data with key availability
                    return $igdbDlcs->map(function ($igdbChild) {
                        $childImage = null;
                        if ($igdbChild->cover && isset($igdbChild->cover->image_id)) {
                            $childImage = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbChild->cover->image_id.'.jpg';
                        }
                        
                        // Check if we have this game in our database and if it has available keys
                        $childGameModel = Game::where('igdb_id', $igdbChild->id)->first();
                        $hasKey = false;
                        $keyCount = 0;
                        
                        if ($childGameModel) {
                            $keyCount = $childGameModel->keys()
                                ->whereNull('owned_user_id')
                                ->where('removed', '=', '0')
                                ->count();
                            $hasKey = $keyCount > 0;
                        }
                        
                        return [
                            'id' => $igdbChild->id, // Use IGDB ID as id
                            'igdb_id' => $igdbChild->id,
                            'name' => $igdbChild->name,
                            'image' => $childImage,
                            'url' => route('games.show', $igdbChild->id),
                            'hasKey' => $hasKey,
                            'keyCount' => $keyCount,
                        ];
                    })->values(); // Reset keys to ensure proper indexing
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
                
                $items = $allChildGames->forPage($currentPage, $perPage)->values();
                
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
            'game'        => GameData::fromModel($game),
            'keys'        => $keys->toArray(),
            'igdb'        => $igdb,
            'genres'      => $genres,
            'screenshots' => $screenshots,
            'parentGame' => $parentGame,
            'childGames' => $childGamesPaginated ? Inertia::scroll(fn () => $childGamesPaginated) : null,
        ]);
    }
}
