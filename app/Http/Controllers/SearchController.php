<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Game;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Inertia\Response;
use Log;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController extends Controller
{
    public function index(Request $request): Response
    {
        $search = mb_trim($request->input('search', ''));

        if ($search === '' || $search === '0') {
            $emptyPaginator = new LengthAwarePaginator(
                collect([]),
                0,
                12,
                1,
                ['path' => $request->url(), 'query' => $request->except('page')]
            );

            return Inertia::render('Search/Index', [
                'title' => 'Search',
                'games' => Inertia::scroll(fn (): LengthAwarePaginator => $emptyPaginator),
            ]);
        }

        $perPage     = 12;
        $currentPage = $request->get('page', 1);

        $limit = config('igdb.per_page_limit', 500);

        $igdbGames = Igdb::select(['name', 'summary', 'id', 'parent_game'])
            ->with(['cover' => ['image_id']])
            ->search($search)
            ->limit($limit)
            ->get();

        $allGames = collect();

        foreach ($igdbGames as $igdbGame) {
            try {
                $game = Game::where('igdb_id', $igdbGame->id)->first();

                if (! $game) {
                    $game = Game::createFromIgdb($igdbGame);
                }

                // Get image from IGDB - handle both object and array formats
                $image = null;
                if ($igdbGame->cover) {
                    if (is_object($igdbGame->cover) && isset($igdbGame->cover->image_id)) {
                        $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbGame->cover->image_id.'.jpg';
                    } elseif (is_array($igdbGame->cover) && isset($igdbGame->cover['image_id'])) {
                        $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbGame->cover['image_id'].'.jpg';
                    }
                }

                // Count available keys
                $keyCount = $game->keys()
                    ->whereNull('owned_user_id')
                    ->where('removed', '=', '0')
                    ->count();
                $hasKey = $keyCount > 0;

                $allGames->push([
                    'id'       => $game->id,
                    'igdb_id'  => $game->igdb_id,
                    'name'     => $igdbGame->name ?? 'Unknown',
                    'image'    => $image,
                    'url'      => route('games.show', $game->igdb_id),
                    'hasKey'   => $hasKey,
                    'keyCount' => $keyCount,
                ]);
            } catch (Exception $e) {
                Log::error('Error processing IGDB game', [
                    'igdb_id' => $igdbGame->id ?? null,
                    'error'   => $e->getMessage(),
                ]);

                // Continue with next game
                continue;
            }
        }

        // Manual pagination
        $total = $allGames->count();
        $items = $allGames->forPage($currentPage, $perPage);

        $paginatedGames = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->except('page')]
        );

        return Inertia::render('Search/Index', [
            'title' => $search,
            'games' => Inertia::scroll(fn (): LengthAwarePaginator => $paginatedGames),
        ]);
    }

    public function autoCompleteGames(Request $request)
    {
        return response()->json(
            Igdb::select(['name', 'id'])
                ->search($request->input('q', ''))
                ->limit(5)
                ->get()
        );
    }
}
