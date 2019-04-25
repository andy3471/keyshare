<?php

namespace App\Http\Controllers;

use App\Game;
use App\Keys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Input as Input;

class GamesController extends Controller
{
    public function index()
    {
        $games = DB::table('games')
                ->distinct()
                ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
                ->join('keys', 'keys.game_id', '=', 'games.id')
                ->where('keys.owned_user_id', '=', null)
                ->orderby('games.name')
                ->paginate(12);

        return $games;
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

        return redirect()->route('game', ['id' => $request->gameid] )->with('message', __('game.gameupdated') );
    }


}
