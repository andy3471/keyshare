<?php

namespace App\Http\Controllers\Web\Keys;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Notifications\KeyAdded;
use App\Resources\PlatformResource;
use App\Services\KarmaService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class KeyController extends Controller
{
    public function create(): Response
    {
        // TODO: Refactor
        $platforms = Cache::remember('platforms', 3600, function (): array|\Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Support\Enumerable|\Spatie\LaravelData\CursorPaginatedDataCollection|\Spatie\LaravelData\DataCollection|\Spatie\LaravelData\PaginatedDataCollection {
            return PlatformResource::collect(Platform::all());
        });

        return Inertia::render('keys/Create', [
            'platforms' => $platforms,
        ]);
    }

    // TODO: Use form request
    // TODO: Refactor
    public function store(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'key_type' => 'required',
            'platform_id' => 'required',
            'key' => 'required',
            'message' => 'max:255',
        ]);

        $key = new Key;
        $key->platform_id = $request->platform_id;
        $key->keycode = $request->key;
        $key->message = $request->message;
        $key->created_user_id = auth()->user()->id;

        $game = Game::where('name', $request->gamename)->first();

        if (! $game) {
            $game = new Game;
            if (config('igdb.enabled')) {
                $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->gamename)->first();

                if ($igdb) {
                    $game->name = $igdb->name;
                    $game->description = $igdb->summary;
                    $game->igdb_id = $igdb->id;
                    $game->image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                    $game->igdb_updated = Carbon::today();
                } else {
                    $game->name = $request->gamename;
                }
            } else {
                $game->name = $request->gamename;
            }

            $game->created_user_id = auth()->user()->id;
            $game->save();
        }

        $key->game_id = $game->id;

        $key->key_type_id = $request->key_type;
        $key->save();

        if (config('services.discord.enabled')) {
            $key->notify(new KeyAdded($key, auth()->user()->id, $game));
        }

        KarmaService::increment(auth()->user(), 1);

        return back()->with('message', __('keys.added'));
    }

    // TODO: Use route model binding
    public function show(Key $key): View
    {
        return view('keys.show')->withKey($key);
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

            KarmaService::decrement(auth()->user(), 1);

            return back()->with('message', __('keys.claimsuccess'));
        }

        return back()->with('error', __('keys.alreadyclaimederror'));
    }

    public function claimed(): View
    {
        return view('games.index')
            ->withTitle('Claimed Keys')
            ->withUrl(route('api.my.keys.claimed.index'));
    }

    public function shared(): View
    {
        return view('games.index')
            ->withTitle('Shared Keys')
            ->withUrl(route('api.my.keys.shared.index'));
    }
}
