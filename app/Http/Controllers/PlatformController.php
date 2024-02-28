<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PlatformController extends Controller
{
    // TODO: Cache this on te model
    // TODO: Only return require attributes
    public function index()
    {
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        return response()->json($platforms);
    }

    // TODO: Use route model binding
    public function show($id): View
    {
        $platform = Platform::find($id);

        return view('games.index')->withTitle($platform->name)->withurl('/platform/get/'.$id);
    }

    // TODO: Use route model binding
    public function getPlatform($id): JsonResponse
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw("games.id, games.name, CASE WHEN igdb_id IS NULL THEN concat('/', games.image) ELSE games.image END as image, concat('/games/', games.id) as url")
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->where('keys.platform_id', '=', $id)
            ->orderby('games.name')
            ->paginate(12);

        return response()->json($games);
    }
}
