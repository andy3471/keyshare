<?php

namespace App\Http\Controllers\WebApi\Search;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class SearchController
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            IgdbGame::select(['name', 'id'])
                ->search($request->get('search'))
                ->get()
        );
    }
}
