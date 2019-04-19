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
            return view('games.index')->withTitle($search)->withurl('/searchresults?search=' . $search  . '&');
        } else {
            $game = $game[0]->id;
            return redirect()->route('game', $game);
        }
    }


    public function searchResults(Request $request)
    {
        $search = $request->search;

        $games = DB::table('games')
                    ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
                    ->where('name', 'like', '%' . $search . '%')
                    ->paginate(12);

        $games->appends(['search' => $search])->links();

        return $games;
    }

    public function gamesList()
    {
        return view('games.index')->withTitle('Games')->withurl('/game/all');
    }

    public function claimedKeys()
    {
         return view('games.index')->withTitle('Claimed Keys')->withurl('/game/claimed');
    }

    public function sharedKeys()
    {
         return view('games.index')->withTitle('Shared Keys')->withurl('/game/shared');
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

    public function passwordResetPage() {
        return view('auth.changepassword');
    }
}
