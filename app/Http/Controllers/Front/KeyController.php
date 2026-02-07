<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Dlc;
use App\Models\Game;
use App\Models\Key;
use App\Models\KeyType;
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
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        // Ensure $platforms is a Collection of Platform models (cache might return array)
        if (!($platforms instanceof \Illuminate\Database\Eloquent\Collection)) {
            $platforms = Platform::all();
        }

        return Inertia::render('Keys/Create', [
            'platforms'  => $platforms->map(fn (Platform $p): \App\DataTransferObjects\PlatformData => \App\DataTransferObjects\PlatformData::fromModel($p))->toArray(),
            'dlcEnabled' => config('app.dlc_enabled', false),
        ]);
    }

    // TODO: Use form request
    // TODO: Refactor
    public function store(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'key_type'    => 'required',
            'platform_id' => ['required', 'uuid', 'exists:platforms,id'],
            'key'         => 'required',
            'message'     => 'max:255',
        ], [
            'platform_id.uuid' => 'Please select a valid platform.',
            'platform_id.exists' => 'The selected platform does not exist.',
        ]);

        $key                  = new Key;
        $key->platform_id     = $request->platform_id;
        $key->keycode         = $request->key;
        $key->message         = $request->message;
        $key->created_user_id = auth()->user()->id;

        if ($request->key_type === '1' || $request->key_type === '2') {
            $game = Game::where('name', $request->gamename)->first();

            if (! $game) {
                $game = new Game;
                if (config('igdb.enabled')) {
                    $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->gamename)->first();

                    if ($igdb) {
                        $game->name         = $igdb->name;
                        $game->description  = $igdb->summary;
                        $game->igdb_id      = $igdb->id;
                        $game->image        = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                        $game->igdb_updated = \Illuminate\Support\Facades\Date::today();
                    } else {
                        $game->name = $request->gamename;
                        $game->description = null;
                    }
                } else {
                    $game->name = $request->gamename;
                    $game->description = null;
                }

                $game->created_user_id = auth()->user()->id;
                $game->save();
            }

            $key->game_id = $game->id;
        }

        if ($request->key_type === '2') {
            $dlc = Dlc::firstOrCreate(
                ['name' => $request->dlcname, 'game_id' => $game->id],
                ['created_user_id' => $key->created_user_id]
            );

            $key->dlc_id = $dlc->id;
        }

        // Set key_type_id (1 = Games, 2 = DLC, 3 = Wallet, 4 = Subscription)
        $key->key_type_id = (int) $request->key_type;
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
        $key->load(['platform', 'createdUser', 'claimedUser', 'game', 'dlc']);

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
        $gamesPaginator = $keys->through(function ($key) {
            $game = $key->game;
            $image = '/images/default-game.png';
            
            if ($game && $game->image) {
                // Format image path: add leading slash if not from IGDB, otherwise use full URL
                $image = $game->igdb_id === null ? '/'.$game->image : $game->image;
            }
            
            return [
                'id' => $key->game_id,
                'name' => $game->name ?? 'Unknown',
                'image' => $image,
                'url' => '/games/'.$key->game_id,
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
        $gamesPaginator = $keys->through(function ($key) {
            $game = $key->game;
            $image = '/images/default-game.png';
            
            if ($game && $game->image) {
                // Format image path: add leading slash if not from IGDB, otherwise use full URL
                $image = $game->igdb_id === null ? '/'.$game->image : $game->image;
            }
            
            return [
                'id' => $key->game_id,
                'name' => $game->name ?? 'Unknown',
                'image' => $image,
                'url' => '/games/'.$key->game_id,
            ];
        });

        return Inertia::render('Keys/Shared', [
            'games' => Inertia::scroll(fn () => $gamesPaginator),
        ]);
    }
}
