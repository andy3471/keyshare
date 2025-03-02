<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Resources\GameResource;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\PaginatedDataCollection;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            GameResource::collect(
                Game::withUnclaimedKeys()
                    ->orderBy('name')
                    ->paginate(), PaginatedDataCollection::class)
        );
    }
}
