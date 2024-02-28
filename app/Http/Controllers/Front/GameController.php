<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index')->withTitle('Games')->withurl(route('api.games.index'));
    }

    // TODO: Refactor

    // TODO: Refactor
    public function show(Game $game): View
    {
        $dlcCount = 0;
        $dlcurl = null;
        $igdb = null;
        $genres = null;
        $screenshots = null;

        $keys = $game->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->where('owned_user_id', null)
            ->where('key_type_id', '1')
            ->with('platform', 'createduser')
            ->get();

        if (config('app.dlc_enabled')) {
            $dlcCount = DB::table('dlcs')
                ->distinct()
                ->selectRaw('dlcs.id, dlcs.name, concat("/", dlcs.image) as image, concat("/games/dlc/", dlcs.id) as url')
                ->join('keys', 'keys.dlc_id', '=', 'dlcs.id')
                ->where('keys.owned_user_id', '=', null)
                ->where('keys.removed', '=', '0')
                ->where('keys.game_id', '=', $game->id)
                ->count();
            $dlcurl = '/games/dlc/get/'.$game->id;
        }

        if ($game->igdb_id) {
            $igdb = Igdb::select(['aggregated_rating', 'aggregated_rating_count'])->with(['genres', 'screenshots'])->where('id', '=', $game->igdb_id)->first();
            $screenshots = $igdb->screenshots;
            $genres = $igdb->genres;
        }

        return view('games.show')
            ->withGame($game)
            ->withKeys($keys)
            ->withDlcurl($dlcurl)
            ->withDlcCount($dlcCount)
            ->withIgdb($igdb)
            ->withGenres($genres)
            ->withScreenshots($screenshots);
    }
}
