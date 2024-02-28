<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DlcController extends Controller
{
    public function index(Game $game): JsonResponse
    {
        $dlc = DB::table('dlcs')
            ->distinct()
            ->selectRaw('dlcs.id, dlcs.name, concat("/", dlcs.image) as image, concat("/games/dlc/", dlcs.id) as url')
            ->join('keys', 'keys.dlc_id', '=', 'dlcs.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('keys.removed', '=', '0')
            ->where('keys.game_id', '=', $game->id)
            ->orderby('dlcs.name')
            ->paginate(12);

        return response()->json($dlc);
    }
}
