<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\KeyData;
use App\DataTransferObjects\PlatformData;
use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Notifications\KeyAdded;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class KeyController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Keys/Create', [
            'platforms' => fn (): array => PlatformData::collect(Cache::remember('platforms', 3600, function () {
                return Platform::all();
            })),
        ]);
    }

    // TODO: Use form request
    // TODO: Refactor
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'platform_id' => ['required', 'uuid', 'exists:platforms,id'],
            'key'         => 'required',
            'message'     => 'max:255',
            'gamename'    => 'required',
        ], [
            'platform_id.uuid'   => 'Please select a valid platform.',
            'platform_id.exists' => 'The selected platform does not exist.',
            'gamename.required'  => 'Please select a game.',
        ]);

        $key                  = new Key;
        $key->platform_id     = $request->platform_id;
        $key->keycode         = $request->key;
        $key->message         = $request->message;
        $key->created_user_id = auth()->user()->id;

        $game = Game::fromIgdbId((int) $request->gamename);

        if (! $game instanceof Game) {
            return back()->withErrors(['gamename' => 'Game not found in IGDB. Please search for a valid game name.']);
        }

        $key->game_id = $game->id;

        $key->save();

        if (config('services.discord.enabled')) {
            $key->notify(new KeyAdded($key, auth()->user()->id, $game));
        }

        Redis::zincrby('karma', 1, auth()->id());

        return back()->with('message', __('keys.added'));
    }

    public function show(Key $key): Response
    {
        return Inertia::render('Keys/Show', [
            'keyData' => fn (): KeyData => KeyData::fromModel(
                $key
                    ->load(['platform', 'createdUser', 'claimedUser', 'game'])
            ),
        ]);
    }

    // TODO: Use route model binding
    // TODO: Refactor
    public function claim(Request $request): RedirectResponse
    {
        $key = Key::where('id', '=', $request->id)->where('owned_user_id', '=', null)->first();

        if ($key) {
            $key = DB::table('keys')
                ->where('id', '=', $request->id)
                ->update(['owned_user_id' => auth()->id()]);

            Redis::zincrby('karma', -1, auth()->id());

            return back()->with('message', __('keys.claimsuccess'));
        }

        return back()->with('error', __('keys.alreadyclaimederror'));
    }

    public function claimed(Request $request): Response
    {
        $keys = auth()->user()->claimedKeys()->with('game')->paginate(12);

        // Transform paginated keys to games format for InfiniteScroll
        $gamesPaginator = $keys->through(function ($key): array {
            $game = $key->game;

            // Get image from IGDB
            $image = null;
            if ($game && $game->igdb_id && config('igdb.enabled')) {
                $igdb = $game->getIgdbData();
                if ($igdb && $igdb->cover && isset($igdb->cover->image_id)) {
                    $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                }
            }

            return [
                'id'       => $game?->id,
                'igdb_id'  => $game?->igdb_id,
                'name'     => $game?->name ?? 'Unknown',
                'image'    => $image,
                'url'      => $game && $game->igdb_id ? route('games.show', $game->igdb_id) : '#',
                'hasKey'   => false, // Already claimed by this user
                'keyCount' => 0,
            ];
        });

        return Inertia::render('Keys/Claimed', [
            'games' => Inertia::scroll(fn () => $gamesPaginator),
        ]);
    }

    public function shared(Request $request): Response
    {
        $keys = auth()->user()->sharedKeys()->with('game')->paginate(12);

        // Transform paginated keys to games format for InfiniteScroll
        $gamesPaginator = $keys->through(function ($key): array {
            $game = $key->game;

            // Get image from IGDB
            $image = null;
            if ($game && $game->igdb_id && config('igdb.enabled')) {
                $igdb = $game->getIgdbData();
                if ($igdb && $igdb->cover && isset($igdb->cover->image_id)) {
                    $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                }
            }

            // Count available keys for this game (excluding this user's shared keys)
            $keyCount = 0;
            $hasKey   = false;
            if ($game) {
                $keyCount = $game->keys()
                    ->whereNull('owned_user_id')
                    ->where('removed', '=', '0')
                    ->where('created_user_id', '!=', auth()->id()) // Don't count own shared keys
                    ->count();
                $hasKey = $keyCount > 0;
            }

            return [
                'id'       => $game?->id,
                'igdb_id'  => $game?->igdb_id,
                'name'     => $game?->name ?? 'Unknown',
                'image'    => $image,
                'url'      => $game && $game->igdb_id ? route('games.show', $game->igdb_id) : '#',
                'hasKey'   => $hasKey,
                'keyCount' => $keyCount,
            ];
        });

        return Inertia::render('Keys/Shared', [
            'games' => Inertia::scroll(fn () => $gamesPaginator),
        ]);
    }
}
