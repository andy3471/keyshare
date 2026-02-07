<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search', '');

        // IGDB is required - games can only be created/searched from IGDB
        if (! config('igdb.enabled')) {
            return Inertia::render('Search/Index', [
                'title' => $search,
                'games' => Inertia::scroll(fn () => collect([])->paginate(12)),
                'error' => 'IGDB API is required but not enabled. Please configure TWITCH_CLIENT_ID and TWITCH_CLIENT_SECRET.',
            ]);
        }

        if (empty($search)) {
            return Inertia::render('Search/Index', [
                'title' => 'Search',
                'games' => Inertia::scroll(fn () => collect([])->paginate(12)),
            ]);
        }

        // Use IGDB fuzzy search
        $perPage = 12;
        $currentPage = $request->get('page', 1);
        
        // Fetch more results than needed for pagination (IGDB search doesn't support pagination directly)
        $limit = config('igdb.per_page_limit', 500);
        $igdbGames = Igdb::select(['name', 'summary', 'id', 'parent_game'])
            ->with(['cover' => ['image_id']])
            ->search($search)
            ->limit($limit)
            ->get();

        // Get or create games from IGDB results and include key availability
        $allGames = collect();
        foreach ($igdbGames as $igdbGame) {
            $game = Game::where('igdb_id', $igdbGame->id)->first();
            if (! $game) {
                $game = Game::createFromIgdb($igdbGame);
            }

            // Get image from IGDB
            $image = null;
            if ($igdbGame->cover && isset($igdbGame->cover->image_id)) {
                $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbGame->cover->image_id.'.jpg';
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
                'name'     => $igdbGame->name,
                'image'    => $image,
                'url'      => route('games.show', $game->igdb_id),
                'hasKey'   => $hasKey,
                'keyCount' => $keyCount,
            ]);
        }

        // Manual pagination
        $total = $allGames->count();
        $items = $allGames->forPage($currentPage, $perPage);

        $paginatedGames = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->except('page')]
        );

        return Inertia::render('Search/Index', [
            'title' => $search,
            'games' => Inertia::scroll(fn (): \Illuminate\Pagination\LengthAwarePaginator => $paginatedGames),
        ]);
    }

    public function autoCompleteGames(Request $request)
    {
        $search = $request->input('q', '');

        // IGDB is required for autocomplete
        if (! config('igdb.enabled')) {
            return response()->json(['error' => 'IGDB API is required but not enabled.'], 400);
        }

        $games = Igdb::select(['name', 'id'])->search($search)->limit(5)->get();

        return response()->json($games);
    }

    public function autoCompleteDlc(Request $request, string $gamename)
    {
        $search = $request->input('q', '');

        // Find game by searching IGDB for the name, then get its DLCs
        if (!config('igdb.enabled')) {
            return response()->json([]);
        }
        
        // Search IGDB for the parent game
        $igdbParent = Igdb::select(['id', 'name'])->where('name', '=', $gamename)->whereNull('parent_game')->first();
        
        if (!$igdbParent) {
            return response()->json([]);
        }
        
        // Find or create the parent game
        $game = Game::where('igdb_id', $igdbParent->id)->first();
        if (!$game) {
            $game = Game::createFromIgdb($igdbParent);
        }
        
        // Get DLCs from IGDB for this parent game
        $igdbDlcs = Igdb::select(['id', 'name'])
            ->where('parent_game', '=', $igdbParent->id)
            ->where('name', 'like', '%'.$search.'%')
            ->limit(5)
            ->get();
        
        // Return DLC data
        return response()->json($igdbDlcs->map(function ($igdbDlc) {
            return [
                'id' => $igdbDlc->id,
                'name' => $igdbDlc->name,
            ];
        }));
    }
}
