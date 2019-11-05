<?php

namespace App\Http\Controllers;

use App\Dlc;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DlcController extends Controller
{
    public function index($id)
    {
        $dlc = DB::table('dlcs')
        ->distinct()
        ->selectRaw('dlcs.id, dlcs.name, dlcs.image, concat("/games/dlc/", dlcs.id) as url')
        ->join('keys', 'keys.dlc_id', '=', 'dlcs.id')
        ->where('keys.owned_user_id', '=', null)
        ->where('keys.removed', '=', '0')
        ->where('keys.game_id', '=', $id)
        ->orderby('dlcs.name')
        ->paginate(12);

        return $dlc;
    }


    public function show(Dlc $dlc)
    {
        $keys = DB::table('keys')
        ->select('keys.id', 'platforms.name as platform', 'users.name as created_user_name', 'users.id as created_user_id')
        ->join('platforms', 'platforms.id', '=', 'keys.platform_id')
        ->join('users', 'users.id', '=', 'keys.created_user_id')
        ->where('dlc_id', '=', $dlc->id)
        ->where('owned_user_id', '=', null)
        ->where('removed', '=', '0')
        ->get();

        return view('dlc.show')->withDlc($dlc)->withKeys($keys);
    }

    public function edit(Dlc $dlc)
    {
        return $dlc;
    }

    public function update(Request $request, Dlc $dlc)
    {

    }

    public function destroy(Dlc $dlc)
    {

    }
}
