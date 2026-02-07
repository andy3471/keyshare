<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\Games\GameData;
use App\DataTransferObjects\Keys\KeyData;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;
use Spatie\LaravelData\DataCollection;

class GameController extends Controller
{
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Game::class);

        $platformIds   = $request->array('platforms');
        $activeGroupId = session('active_group_id');
        $userGroupIds  = auth()->user()->groups()->pluck('groups.id');

        return Inertia::render('Games/Index', [
            'title' => fn (): string => 'Games',
            'games' => Inertia::scroll(function () use ($platformIds, $activeGroupId, $userGroupIds) {
                $games = Game::query()
                    ->whereHas('keys', function ($query) use ($platformIds, $activeGroupId, $userGroupIds): void {
                        $query->whereNull('owned_user_id');

                        if ($activeGroupId) {
                            $query->where('group_id', $activeGroupId);
                        } else {
                            $query->whereIn('group_id', $userGroupIds);
                        }

                        if ($platformIds !== []) {
                            $query->whereIn('platform_id', $platformIds);
                        }
                    })
                    ->with('keys')
                    ->paginate(12);

                $games->through(fn ($game): GameData => GameData::from($game)->include('hasKey', 'keyCount'));

                return $games;
            }),
            'selectedPlatforms' => fn () => $platformIds,
        ]);
    }

    public function show(Request $request, string $igdb_id): Response
    {
        $game = Game::fromIgdbId((int) $igdb_id);

        abort_if(! $game instanceof Game, 404);

        $this->authorize('view', $game);

        $activeGroupId = session('active_group_id');
        $userGroupIds  = auth()->user()->groups()->pluck('groups.id');

        return Inertia::render('Games/Show', [
            'game'        => fn (): GameData => GameData::from($game)->include('genres', 'screenshots', 'aggregated_rating', 'aggregated_rating_count'),
            'keys'        => fn (): DataCollection => KeyData::collect(
                KeyData::collect(
                    $game->keys()
                        ->select('id', 'platform_id', 'created_user_id', 'group_id')
                        ->whereNull('owned_user_id')
                        ->when(
                            $activeGroupId,
                            fn ($q) => $q->where('group_id', $activeGroupId),
                            fn ($q) => $q->whereIn('group_id', $userGroupIds),
                        )
                        ->with('platform', 'createdUser')
                        ->get(), DataCollection::class)
            ),
            'parentGame'  => function () use ($game): ?GameData {
                $parentId = $game->parent_game_id;

                if (! $parentId) {
                    return null;
                }

                $igdbParent = IgdbGame::select(['name', 'summary', 'id'])
                    ->with(['cover' => ['image_id']])
                    ->where('id', '=', $parentId)
                    ->first();

                if ($igdbParent) {
                    return GameData::fromIgdb($igdbParent);
                }
            },
            'childGames'  => Inertia::scroll(function () use ($game, $request): LengthAwarePaginator {
                $allChildGames = IgdbGame::select(['name', 'summary', 'id'])
                    ->with(['cover' => ['image_id']])
                    ->where('parent_game', '=', $game->igdb_id)
                    ->limit(12)
                    ->get();

                $perPage     = 12;
                $currentPage = (int) $request->get('page', 1);
                $total       = $allChildGames->count();

                $lastPage    = (int) ceil($total / $perPage);
                $currentPage = min($currentPage, max(1, $lastPage));

                $items = $allChildGames->forPage($currentPage, $perPage)
                    ->map(fn (IgdbGame $igdbChild): GameData => GameData::fromIgdb($igdbChild)->include('keyCount'))
                    ->values();

                $queryParams = $request->except('childGames_page');

                return new LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $currentPage,
                    [
                        'path'     => $request->url(),
                        'query'    => $queryParams,
                        'pageName' => 'childGames_page',
                    ]
                );
            }),
        ]);
    }
}
