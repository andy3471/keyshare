<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Platform;

class PlatformsController extends Controller
{
    public function show($id)
    {
        $platform = Platform::find($id);
        return view('games.index')->withTitle($platform->name)->withurl('/platform/get/' . $id);
    }

    public function getPlatform($id)
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw('games.id, games.name, concat("/", games.image) as image, concat("/games/", games.id) as url')
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->where('keys.platform_id', '=', $id)
            ->orderby('games.name')
            ->paginate(12);

        return $games;
    }
}
