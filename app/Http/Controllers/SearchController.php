<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\Games\GameData;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class SearchController extends Controller
{
    public function index(Request $request): Response
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
                    ->map(fn ($gameData) => $gameData->include('hasKey', 'keyCount'))
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

    public function autocomplete(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Game::class);

        $query = mb_trim($request->input('q', ''));

        if ($query === '' || $query === '0') {
            return response()->json([]);
        }

        return response()->json(
            IgdbGame::select(['name', 'id'])
                ->search($query)
                ->limit(5)
                ->get()
        );
    }
}
