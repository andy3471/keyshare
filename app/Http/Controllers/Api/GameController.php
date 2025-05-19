<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw("games.id, games.name, games.image, concat('/games/', games.id) as url")
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->oldest('games.name')
            ->paginate(12);

        return response()->json($games);
    }
}
