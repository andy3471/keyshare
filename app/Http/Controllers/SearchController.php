<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;

        $game = DB::table('games')
            ->select('id')
            ->where('name', '=', $search)
            ->where('removed', '=', '0')
            ->get();

        if (count($game) == 0) {
            return view('games.index')->withTitle($search)->withurl('/search/get/?search=' . $search  . '&');
        } else {
            $game = $game[0]->id;
            return redirect()->route('game', $game);
        }
    }


    public function getSearch(Request $request)
    {
        $search = $request->search;

        $games = DB::table('games')
            ->selectRaw('games.id, games.name, games.image, concat("/games/", games.id) as url')
            ->where('name', 'like', '%' . $search . '%')
            ->where('removed', '=', '0')
            ->paginate(12);

        $games->appends(['search' => $search])->links();

        return $games;
    }

    public function autocomplete($search)
    {

        $games = DB::table('games')
            ->select('id', 'name')
            ->where('name', 'like', '%' . $search . '%')
            ->where('removed', '=', '0')
            ->limit(5)
            ->get();

        return json_encode($games);
    }
}
