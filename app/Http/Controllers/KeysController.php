<?php

namespace App\Http\Controllers;

use App\Key;
use App\Platform;
use App\Game;
use Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Dlc;
use Auth;

class KeysController extends Controller
{

    public function create()
    {
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        return view('keys.create')->with('platforms', $platforms);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'key_type' => 'required',
            'platform_id' => 'required',
            'key' => 'required',
            'message' => 'max:255'
        ]);

        $key = new Key;
        $key->platform_id = $request->platform_id;
        $key->keycode = $request->key;
        $key->message = $request->message;
        $key->created_user_id = Auth::id();



        if ($request->key_type == '1' or $request->key_type == '2') {
            $game = Game::firstOrCreate(
                ['name' => $request->gamename],
                ['created_user_id' => $key->created_user_id]
            );

            $key->game_id = $game->id;
        }

        if ($request->key_type == '2') {
            $dlc = Dlc::firstOrCreate(
                ['name' => $request->dlcname, 'game_id' => $game->id],
                ['created_user_id' => $key->created_user_id]
            );

            $key->dlc_id = $dlc->id;
        }

        $key->save();

        Redis::zincrby('karma', 1, auth()->id());

        return redirect()->back()->with('message', __('keys.added'));
    }

    public function show($id)
    {

        $key = DB::table('keys')
            ->select('keys.id', 'keys.keycode as keycode', 'keys.message as message', 'games.name as game', 'platforms.name as platform', 'users.name as created_user_name', 'users.id as created_user_id', 'users.image as created_user_image', 'users.bio as created_user_bio', 'keys.owned_user_id')
            ->where('keys.id', '=', $id)
            ->where('keys.removed', '=', '0')
            ->join('platforms', 'platforms.id', '=', 'platforms.id')
            ->join('users', 'users.id', '=', 'keys.created_user_id')
            ->join('games', 'games.id', '=', 'keys.game_id')
            ->get();

        $key = $key[0];
        return view('keys.show')->withKey($key);
    }

    public function claim(Request $request)
    {
        $key = DB::table('keys')
            ->where('id', '=', $request->id)
            ->where('owned_user_id', '=', null)
            ->count();

        if ($key == 1) {

            $key = DB::table('keys')
                ->where('id', '=', $request->id)
                ->update(['owned_user_id' => auth()->id()]);

            Redis::zincrby('karma', -1, auth()->id());
            return redirect()->back()->with('message', __('keys.claimsuccess'));
        } else {
            return redirect()->back()->with('error', __('keys.alreadyclaimederror'));
        }
    }

    public function showClaimed()
    {
        return view('games.index')->withTitle('Claimed Keys')->withurl('/claimedkeys/get');
    }

    public function getClaimed()
    {
        $games = DB::table('games')
            ->selectRaw('keys.id, games.name, games.image, concat("/keys/", keys.id) as url')
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', auth()->id())
            ->orderby('games.name')
            ->paginate(12);

        return $games;
    }

    public function showShared()
    {
        return view('games.index')->withTitle('Shared Keys')->withurl('/sharedkeys/get');
    }

    public function getShared()
    {
        $games = DB::table('games')
            ->selectRaw('keys.id, games.name, games.image, concat("/keys/", keys.id) as url')
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.created_user_id', '=', auth()->id())
            ->orderby('games.name')
            ->paginate(12);

        return $games;
    }
}
