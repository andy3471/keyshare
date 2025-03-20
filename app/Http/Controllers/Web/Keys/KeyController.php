<?php

namespace App\Http\Controllers\Web\Keys;

use App\Http\Controllers\Controller;
use App\Http\Requests\Keys\StoreKeyRequest;
use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Notifications\KeyAdded;
use App\Resources\PlatformResource;
use App\Services\KarmaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class KeyController extends Controller
{
    public function create(): Response
    {
        $platforms = Cache::remember('platforms:all', 3600, function () {
            return PlatformResource::collect(Platform::all());
        });

        return Inertia::render('keys/Create', [
            'platforms' => $platforms,
        ]);
    }

    public function store(StoreKeyRequest $request): RedirectResponse
    {
        $game = Game::findOrCreateFromIgdb($request->gamename, auth()->id());

        $key = Key::create([
            'platform_id' => $request->platform_id,
            'keycode' => $request->key,
            'message' => $request->message,
            'created_by_user_id' => auth()->id(),
            'game_id' => $game->id,
            'key_type_id' => $request->key_type,
        ]);

        if (config('services.discord.enabled')) {
            $key->notify(new KeyAdded($key, auth()->id(), $game));
        }

        KarmaService::increment(auth()->user(), 1);

        return back()->with('message', __('keys.added'));
    }

    //    // TODO: Use route model binding
    //    public function show(Key $key): View
    //    {
    //        return view('keys.show')->withKey($key);
    //    }
    //
    //    // TODO: Use route model binding
    //    // TODO: Refactor
    //    public function claim(Request $request): RedirectResponse
    //    {
    //        $key = Key::where('id', '=', $request->id)->where('owned_user_id', '=', null)->first();
    //
    //        if ($key) {
    //            $key = DB::table('keys')
    //                ->where('id', '=', $request->id)
    //                ->update(['owned_user_id' => auth()->id()]);
    //
    //            KarmaService::decrement(auth()->user(), 1);
    //
    //            return back()->with('message', __('keys.claimsuccess'));
    //        }
    //
    //        return back()->with('error', __('keys.alreadyclaimederror'));
    //    }
    //
    //    public function claimed(): Response
    //    {
    //        return Inertia::render('games/IndexGames', [
    //            'title' => 'Claimed Keys',
    //            'url' => route('api.my.keys.claimed.index')
    //        ]);
    //    }

    //    public function shared(): Response
    //    {
    //        return Inertia::render('games/IndexGames', [
    //            'title' => 'Shared Keys',
    //            'url' => route('api.my.keys.shared.index')
    //        ]);
    //    }
}
