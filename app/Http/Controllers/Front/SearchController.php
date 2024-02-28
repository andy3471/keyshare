<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class SearchController extends Controller
{
    // TODO: Refactor
    public function index(Request $request): View|RedirectResponse
    {
        $search = $request->search;

        $game = DB::table('games')
            ->select('id')
            ->where('name', '=', $search)
            ->where('removed', '=', '0')
            ->get();

        if (count($game) == 0) {
            if (config('igdb.enabled')) {
                $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->search)->first();

                if ($igdb) {
                    $game = new Game;
                    $game->name = $igdb->name;
                    $game->description = $igdb->summary;
                    $game->igdb_id = $igdb->id;
                    $game->image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                    $game->igdb_updated = Carbon::today();
                    $game->created_user_id = Auth::id();
                    $game->save();

                    return redirect()->route('games.index', $game);
                }
            }

            return view('games.index')->withTitle($search)->withurl(route('api.games.search.index', ['search' => $search]));
        } else {
            $game = $game[0]->id;

            return redirect()->route('games.index', $game);
        }
    }

    // TODO: Refactor

}
