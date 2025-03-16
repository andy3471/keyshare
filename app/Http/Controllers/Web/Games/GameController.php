<?php

namespace App\Http\Controllers\Web\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GameController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('games/IndexGames');
    }

    // TODO: Refactor

    // TODO: Refactor
    public function show(Game $game): View
    {
        //        $dlcCount = 0;
        //        $dlcurl = null;
        //        $igdb = null;
        //        $genres = null;
        //        $screenshots = null;
        //
        //        $keys = $game->keys()
        //            ->select('id', 'platform_id', 'created_user_id')
        //            ->where('owned_user_id', null)
        //            ->where('key_type_id', '1')
        //            ->with('platform', 'createduser')
        //            ->get();
        //
        //        if ($game->igdb_id) {
        //            $igdb = Igdb::select(['aggregated_rating', 'aggregated_rating_count'])->with(['genres', 'screenshots'])->where('id', '=', $game->igdb_id)->first();
        //            $screenshots = $igdb->screenshots;
        //            $genres = $igdb->genres;
        //        }
        return Inertia::render('games/ShowGame', [
            'game' => $game,
        ]);
    }
}
