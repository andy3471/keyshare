<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamesController extends Controller
{

    public function index()
    {
        return view('games.index')->withTitle('Games')->withurl('/games/get');
    }

    public function getGames()
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

    public function show($id)
    {
        $game = Game::find($id);

        $keys = Game::find($id)->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->where('owned_user_id', null)
            ->where('key_type_id', '1')
            ->with('platform', 'createduser')
            ->get();

        $dlcurl = "/games/dlc/get/" . $id;

        return view('games.show')->withGame($game)->withKeys($keys)->withDlcurl($dlcurl);
    }

    public function edit($id)
    {
        $game = Game::find($id);

        return view('games.edit')->withGame($game);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:width=460,height=215'
        ]);

        if ($request->hasFile('image')) {
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '.' . $extension;
            $folderToStore = 'images/games/';
            $fullImagePath = $folderToStore . $filenameToStore;

            $path = $request->file('image')->storeAs('public/' . $folderToStore, $filenameToStore);
        }

        $game = Game::find($request->gameid);
        $game->name = $request->name;
        $game->description = $request->description;
        if ($request->hasFile('image')) {
            $game->image = 'storage/' . $fullImagePath;
        }
        $game->save();

        return redirect()->route('game', ['id' => $request->gameid])->with('message', __('games.gameupdated'));
    }
}
