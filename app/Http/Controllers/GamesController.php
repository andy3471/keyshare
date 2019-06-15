<?php

namespace App\Http\Controllers;

use App\Game;
use App\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Input as Input;
use App\Platform;
use Cache;
use Illuminate\Support\Facades\Redis;

class GamesController extends Controller
{
    public function index()
    {
        $games = DB::table('games')
                ->distinct()
                ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
                ->join('keys', 'keys.game_id', '=', 'games.id')
                ->where('keys.owned_user_id', '=', null)
                ->where('games.removed', '=', '0')
                ->where('keys.removed', '=', '0')
                ->orderby('games.name')
                ->paginate(12);

        return $games;
    }

    public function store(Request $request) {

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

        return redirect()->back()->with( 'message', __('keys.added') );
    }

    public function show($id)
    {
        $game = Game::find($id);

        $keys = DB::table('keys')
                    ->select('keys.id', 'platforms.name as platform', 'users.name as created_user_name', 'users.id as created_user_id')
                    ->join('platforms', 'platforms.id', '=', 'keys.platform_id')
                    ->join('users', 'users.id', '=', 'keys.created_user_id')
                    ->where('game_id', '=', $id)
                    ->where('owned_user_id', '=', null)
                    ->where('removed', '=', '0')
                    ->get();

        return view('games.show')->withGame($game)->withKeys($keys);
    }

    public function edit($id)
    {
        $game = Game::find($id);

        $keys = DB::table('keys')
                    ->select('keys.id', 'platforms.name as platform', 'users.name as created_user_name', 'users.id as created_user_id')
                    ->join('platforms', 'platforms.id', '=', 'keys.platform_id')
                    ->join('users', 'users.id', '=', 'keys.created_user_id')
                    ->where('game_id', '=', $id)
                    ->where('owned_user_id', '=', null)
                    ->where('removed', '=', '0')
                    ->get();

        return view('games.edit')->withGame($game);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:width=460,height=215'
        ]);

        if($request->hasFile('image')){
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '.'. $extension;
            $folderToStore = 'images/games/';
            $fullImagePath = $folderToStore . $filenameToStore;

            $path = $request->file('image')->storeAs( 'public/' . $folderToStore , $filenameToStore);
        }

        $game = Game::find($request->gameid);
        $game->name = $request->name;
        $game->description = $request->description;
        if($request->hasFile('image')){
            $game->image = 'storage/' . $fullImagePath;
        }
        $game->save();

        return redirect()->route('game', ['id' => $request->gameid] )->with('message', __('games.gameupdated') );
    }


}
