<?php

namespace App\Http\Controllers;

use App\Models\Dlc;
use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use App\Notifications\KeyAdded;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;
use Redirect;

class KeyController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        // TODO tidy this
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });

        return Inertia::render('Keys/Create', [
            'platforms' => $platforms,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // TODO Make this a request + job
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
        $key->created_user_id = Auth::id();

        if ($request->key_type == '1' or $request->key_type == '2') {
            $game = Game::where('name', $request->gamename)->first();

            if(! $game) {
                $game = new Game;
                if(config('igdb.enabled')) {
                    $igdb = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('name', '=', $request->gamename)->first();

                    if($igdb) {
                        $game->name = $igdb->name;
                        $game->description = $igdb->summary;
                        $game->igdb_id = $igdb->id;
                        $game->image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $igdb->cover->image_id . '.jpg';
                        $game->igdb_updated = Carbon::today();
                    } else {
                        $game->name = $request->gamename;
                    }
                } else {
                    $game->name = $request->gamename;
                }
                $game->created_user_id = Auth::id();
                $game->save();
            }

            $key->game_id = $game->id;
        }

        if ($request->key_type == '2') {
            $dlc = Dlc::firstOrCreate(
                ['name' => $request->dlcname, 'game_id' => $game->id],
                ['created_user_id' => $key->created_user_id]
            );

            $key->dlc_id = $dlc->id;
        }

        $key->key_type_id = $request->key_type;
        $key->save();

        if(config('services.discord.enabled')) {
            $key->notify(new KeyAdded($key, Auth::user(), $game));
        }

        Redis::zincrby('karma', 1, auth()->id());
        return Redirect::back();
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $key = Key::where('id', '=', $id)->with('platform')->with('createdUser')->first();

        return Inertia::render('Keys/Show', [
            'key' => $key,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function claim(Request $request)
    {
        // TODO tidy this
        $key = Key::where('id', '=', $request->key)->where('owned_user_id', '=', null)->first();

        if ($key) {
            $key = DB::table('keys')
                ->where('id', '=', $request->key)
                ->update(['owned_user_id' => auth()->id()]);
            Redis::zincrby('karma', -1, auth()->id());
        }

        return Redirect::route('key.show', [$request->key]);
    }

    /**
     * @return \Inertia\Response
     */
    public function showClaimed()
    {
        return Inertia::render('Games', [
            'url' => '/claimedkeys/get',
            'title' => 'Claimed Keys',
        ]);
    }

    /**
     * @return mixed
     */
    public function getClaimed()
    {
        return User::find(Auth::id())->claimedKeys()->paginate(12);
    }

    /**
     * @return \Inertia\Response
     */
    public function showShared()
    {
        return Inertia::render('Games', [
            'url' => '/sharedkeys/get',
            'title' => 'Shared Keys',
        ]);
    }

    /**
     * @return mixed
     */
    public function getShared()
    {
        return User::find(Auth::id())->sharedKeys()->paginate(12);
    }
}
