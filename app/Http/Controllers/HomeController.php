<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (Auth::guest()) {
            return view('auth.login');
        }
        return redirect()->route('games');
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $game = DB::table('games')
                ->select('id')
                ->where('name', '=', $search)
                ->get();

        if (count($game) == 0) {

            $games = DB::table('games')
                    ->select('games.id', 'games.name', 'games.name as key_id')
                    ->where('name', 'like', '%' . $search . '%')
                    ->paginate(12);

            return view('games.index')->withGames($games)->with('title', $search);
        } else {
            $game = $game[0]->id;
            return redirect()->route('game', $game);
        }
    }

    public function autocomplete($search)
    {

        $games = DB::table('games')
                ->select('id','name')
                ->where('name', 'like', '%' . $search . '%')
                ->limit(5)
                ->get();

        return json_encode($games);

    }
}
