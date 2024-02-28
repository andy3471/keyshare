<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PlatformController extends Controller
{
    // TODO: Cache this on te model
    // TODO: Only return require attributes
    public function index(): JsonResponse
    {
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        return response()->json($platforms);
    }

    public function show(Platform $platform): JsonResponse
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw("games.id, games.name, CASE WHEN igdb_id IS NULL THEN concat('/', games.image) ELSE games.image END as image, concat('/games/', games.id) as url")
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->where('keys.platform_id', '=', $platform->id)
            ->orderby('games.name')
            ->paginate(12);

        return response()->json($games);
    }
}
