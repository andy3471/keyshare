<?php

namespace App\Http\Controllers;

use App\Key;
use App\Platform;
use App\Game;
use Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class KeysController extends Controller
{

    public function create()
    {
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        return view('games.addkey')->with('platforms', $platforms);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'gamename' => 'required',
            'platform_id' => 'required',
            'key' => 'required',
            'message' => 'max:255'
        ]);

        //Check Game Exists
        $game = DB::table('games')
            ->where('name', '=', $request->gamename)
            ->get();

        //If it doesn't exist, create it
        if (count($game) == 0) {
            $game = Game::create([
                'created_user_id' => auth()->id(),
                'name' => $request->gamename,
            ]);

            $game = $game->id;
        } else {
            $game = $game[0]->id;
        }

        $key = Key::create([
            'game_id' => $game,
            'platform_id' => $request->platform_id,
            'created_user_id' => auth()->id(),
            'keycode' => $request->key,
            'message' => $request->message
        ]);

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
