<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\GameData;
use App\DataTransferObjects\KeyData;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\KeyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GameController extends Controller
{
    public function index(Request $request): Response
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw("games.id, games.name, CASE WHEN igdb_id IS NULL THEN concat('/', games.image) ELSE games.image END as image, concat('/games/', games.id) as url")
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->oldest('games.name')
            ->paginate(12);

        return Inertia::render('Games/Index', [
            'title' => 'Games',
            'games' => Inertia::scroll(fn () => $games),
        ]);
    }

    public function show(Request $request, Game $game): Response
    {
        $igdb        = null;
        $genres      = null;
        $screenshots = null;

        $keys = $game->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->where('owned_user_id')
            ->where('key_type_id', KeyType::getIdByName('Games'))
            ->with('platform', 'createdUser')
            ->get()
            ->map(fn (\App\Models\Key $key): KeyData => KeyData::fromModel($key));

        $dlcGames = [];
        $dlcPagination = null;
        if (config('app.dlc_enabled')) {
            $dlcQuery = DB::table('dlcs')
                ->distinct()
                ->selectRaw('dlcs.id, dlcs.name, CASE WHEN dlcs.image IS NULL THEN NULL ELSE concat("/", dlcs.image) END as image, concat("/dlc/", dlcs.id) as url')
                ->join('keys', 'keys.dlc_id', '=', 'dlcs.id')
                ->where('keys.owned_user_id', '=', null)
                ->where('keys.removed', '=', '0')
                ->where('keys.game_id', '=', $game->id);
            
            $dlcPaginated = $dlcQuery->paginate(12);
            $dlcGames = $dlcPaginated->items();
            $dlcPagination = [
                'current_page' => $dlcPaginated->currentPage(),
                'last_page' => $dlcPaginated->lastPage(),
                'per_page' => $dlcPaginated->perPage(),
                'total' => $dlcPaginated->total(),
            ];
        }

        if ($game->igdb_id) {
            $igdbModel = Igdb::select(['aggregated_rating', 'aggregated_rating_count'])->with(['genres', 'screenshots'])->where('id', '=', $game->igdb_id)->first();
            if ($igdbModel) {
                $igdb = [
                    'aggregated_rating'       => $igdbModel->aggregated_rating,
                    'aggregated_rating_count' => $igdbModel->aggregated_rating_count,
                ];
                $screenshots = $igdbModel->screenshots?->map(fn ($s): array => ['id' => $s->id, 'image_id' => $s->image_id])->toArray();
                $genres      = $igdbModel->genres?->map(fn ($g): array => ['id' => $g->id, 'name' => $g->name])->toArray();
            }
        }

        return Inertia::render('Games/Show', [
            'game'        => GameData::fromModel($game),
            'keys'        => $keys->toArray(),
            'dlcGames'    => $dlcGames,
            'dlcPagination' => $dlcPagination,
            'igdb'        => $igdb,
            'genres'      => $genres,
            'screenshots' => $screenshots,
        ]);
    }
}
