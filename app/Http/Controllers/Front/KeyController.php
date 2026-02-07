<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Notifications\KeyAdded;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class KeyController extends Controller
{
    // TODO: Move caching to the platforms model
    public function create(): Response
    {
        // IGDB is required for game creation
        if (! config('igdb.enabled')) {
            return Inertia::render('Keys/Create', [
                'platforms'  => [],
                'error'      => 'IGDB API is required but not enabled. Please configure TWITCH_CLIENT_ID and TWITCH_CLIENT_SECRET in your .env file.',
            ]);
        }

        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        // Ensure $platforms is a Collection of Platform models (cache might return array)
        if (! ($platforms instanceof \Illuminate\Database\Eloquent\Collection)) {
            $platforms = Platform::all();
        }

        return Inertia::render('Keys/Create', [
            'platforms'  => $platforms->map(fn (Platform $p): \App\DataTransferObjects\PlatformData => \App\DataTransferObjects\PlatformData::fromModel($p))->toArray(),
        ]);
    }

    // TODO: Use form request
    // TODO: Refactor
    public function store(Request $request): RedirectResponse
    {

        // IGDB is required - games can only be created from IGDB
        if (! config('igdb.enabled')) {
            return back()->withErrors(['gamename' => 'IGDB API is required but not enabled. Please configure TWITCH_CLIENT_ID and TWITCH_CLIENT_SECRET.']);
        }

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

        // Search for game in IGDB (could be a regular game or DLC)
        // Load parent_game relationship so createFromIgdb can detect DLCs automatically
        $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id'], 'parent_game'])->where('name', '=', $request->gamename)->first();

        if (! $igdb) {
            return back()->withErrors(['gamename' => 'Game not found in IGDB. Please search for a valid game name.']);
        }

        // createFromIgdb will automatically detect if it's a DLC and handle parent game creation
        $game         = Game::createFromIgdb($igdb);
        $key->game_id = $game->id;

        $key->save();

        if (config('services.discord.enabled')) {
            $key->notify(new KeyAdded($key, auth()->user()->id, $game));
        }

        Redis::zincrby('karma', 1, auth()->id());

        return back()->with('message', __('keys.added'));
    }

    // TODO: Use route model binding
    public function show(Key $key): Response
    {
        $key->load(['platform', 'createdUser', 'claimedUser', 'game']);

        return Inertia::render('Keys/Show', [
            'keyData' => \App\DataTransferObjects\KeyData::fromModel($key),
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
            $hasKey = false;
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
