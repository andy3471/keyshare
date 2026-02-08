<?php

declare(strict_types=1);

namespace App\Http\Controllers\Search;

use App\DataTransferObjects\Search\AutocompleteGameData;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class AutocompleteSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Game::class);

        $query = mb_trim($request->input('q', ''));

        if ($query === '' || $query === '0') {
            return response()->json([]);
        }

        return response()->json(
            AutocompleteGameData::collect(
                IgdbGame::select(['name', 'id'])
                    ->search($query)
                    ->limit(5)
                    ->get()
            )
        );
    }
}
