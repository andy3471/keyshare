<?php

namespace App\Http\Controllers;

use App\Key;
use App\Platform;
use App\Game;
use Cache;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Dlc;
use Auth;

class KeyController extends Controller
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

        $key->key_type_id = $request->key_type;
        $key->save();

        Redis::zincrby('karma', 1, auth()->id());
        return redirect()->back()->with('message', __('keys.added'));
    }

    public function show($id)
    {

        $key = Key::where('id', '=', $id)->with('platform')->first();

        return view('keys.show')->withKey($key);
    }

    public function claim(Request $request)
    {
        $key = Key::where('id', '=', $request->id)->where('owned_user_id', '=', null)->first();

        if ($key) {
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
        return view('games.index')->withTitle('Claimed Keys')->withUrl('/claimedkeys/get');
    }

    public function getClaimed()
    {
        $keys = User::find(Auth::id())->claimedKeys()->paginate(12);
        return $keys;
    }

    public function showShared()
    {
        return view('games.index')->withTitle('Shared Keys')->withUrl('/sharedkeys/get');
    }

    public function getShared()
    {
        $keys = User::find(Auth::id())->sharedKeys()->paginate(12);
        return $keys;
    }
}
