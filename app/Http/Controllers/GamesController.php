<?php

namespace App\Http\Controllers;

use App\Games;
use App\Keys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamesController extends Controller
{

    public function index()
    {
        $games = DB::table('games')
                ->distinct()
                ->select('games.id', 'games.name', 'keys.id as key_id')
                ->join('keys', 'keys.game_id', '=', 'games.id')
                ->where('keys.owned_user_id', '=', null)
                ->orderby('games.name')
                ->paginate(12);

        return view('games.index')->withGames($games)->with('title', 'Games');
    }

    public function show($id)
    {
        $game = Games::find($id);

        $keys = DB::table('keys')
                    ->select('keys.id', 'platforms.name as platform', 'users.name as created_user_name', 'users.id as created_user_id')
                    ->join('platforms', 'platforms.id', '=', 'keys.platform_id')
                    ->join('users', 'users.id', '=', 'keys.created_user_id')
                    ->where('game_id', '=', $id)
                    ->where('owned_user_id', '=', null)
                    ->get();

        return view('games.show')->withGame($game)->withKeys($keys);
    }

    public function search($search)
    {

    }


}
