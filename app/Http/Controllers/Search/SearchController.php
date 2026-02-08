<?php

declare(strict_types=1);

namespace App\Http\Controllers\Search;

use App\DataTransferObjects\Games\GameData;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class SearchController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $this->authorize('viewAny', Game::class);

        $search = mb_trim($request->input('search', ''));

        return Inertia::render('Search/Index', [
            'title' => fn (): string => $search ?: 'Search',
            'games' => Inertia::scroll(function () use ($search, $request): LengthAwarePaginator {
                if ($search === '' || $search === '0') {
                    return new LengthAwarePaginator(
                        collect([]),
                        0,
                        12,
                        1,
                        ['path' => $request->url(), 'query' => $request->except('page')]
                    );
                }

                $perPage     = 12;
                $currentPage = (int) $request->get('page', 1);

                $igdbGames = IgdbGame::select(['name', 'summary', 'id'])
                    ->with(['cover' => ['image_id']])
                    ->search($search)
                    ->limit(config('igdb.per_page_limit', 500))
                    ->get();

                $allGames = $igdbGames->map(fn (IgdbGame $igdbGame): GameData => GameData::fromIgdb($igdbGame));
                $total    = $allGames->count();
                $items    = $allGames->forPage($currentPage, $perPage)
                    ->map(fn ($gameData) => $gameData->include('hasKey', 'keyCount', 'platforms'))
                    ->values();

                return new LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $currentPage,
                    ['path' => $request->url(), 'query' => $request->except('page')]
                );
            }),
        ]);
    }
}
