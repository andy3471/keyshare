<?php

namespace App\Http\Controllers\Api\Search;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->search;

        $games = DB::table('games')
            ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
            ->where('name', 'like', '%'.$search.'%')
            ->where('removed', '=', '0')
            ->paginate(12);

        $games->appends(['search' => $search])->render();

        return response()->json($games);
    }

    public function autoCompleteGames(string $search): JsonResponse
    {
        return response()->json(
            Igdb::select(['name', 'id'])
                ->search($search)
                ->get()
        );
    }
}
