<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index')->withTitle('Games')->withurl('/games/get');
    }

    // TODO: Refactor
    public function getGames(): JsonResponse
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw("games.id, games.name, games.image, concat('/games/', games.id) as url")
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->orderby('games.name')
            ->paginate(12);

        return response()->json($games);
    }

    // TODO: Refactor
    public function show($id): View
    {
        $game = Game::find($id);
        $dlcCount = 0;
        $dlcurl = null;
        $igdb = null;
        $genres = null;
        $screenshots = null;
        $keys = Game::find($id)->keys()
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
                ->where('keys.game_id', '=', $id)
                ->count();
            $dlcurl = '/games/dlc/get/'.$id;
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
