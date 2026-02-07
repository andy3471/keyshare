<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\Games\GameData;
use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Keys\KeyData;
use App\DataTransferObjects\Platforms\PlatformData;
use App\DataTransferObjects\Search\AutocompleteGameData;
use App\Http\Requests\StoreGameKeyRequest;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use App\Notifications\KeyAdded;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;
use Inertia\Response;

class KeyController extends Controller
{
    public function create(Request $request): Response
    {
        $this->authorize('create', Key::class);

        $user          = auth()->user();
        $activeGroupId = session('active_group_id');

        return Inertia::render('Keys/Create', [
            'platforms' => fn (): Collection => PlatformData::collect(Cache::remember('platforms', 3600, function () {
                return Platform::all();
            })),
            'game'          => fn (): ?AutocompleteGameData => $request->filled('game_id') ? AutocompleteGameData::fromIgdbId((int) $request->string('game_id')->toString()) : null,
            'groups'        => fn () => $user->groups()->get()->map(fn (Group $group) => GroupData::fromModel($group)),
            'activeGroupId' => fn () => $activeGroupId,
        ]);
    }

    public function store(StoreGameKeyRequest $request): RedirectResponse
    {
        $this->authorize('create', Key::class);

        $groupId = $request->validated('group_id');
        $group   = Group::findOrFail($groupId);

        abort_unless($group->hasMember(auth()->user()), 403, 'You are not a member of this group.');

        $game = Game::fromIgdbId((int) $request->igdb_id);

        $key = auth()
            ->user()
            ->sharedKeys()
            ->create(array_merge(
                $request->validated(),
                [
                    'game_id'  => $game->id,
                    'group_id' => $group->id,
                ]
            ));

        if (config('services.discord.enabled')) {
            $key->notify(new KeyAdded($key, auth()->user()->id, $game));
        }

        Redis::zincrby('karma', 1, auth()->id());

        return back()->with('message', __('keys.added'));
    }

    public function show(Key $key): Response
    {
        $this->authorize('view', $key);

        return Inertia::render('Keys/Show', [
            'keyData' => fn (): KeyData => KeyData::fromModel(
                $key
                    ->load(['platform', 'createdUser', 'claimedUser', 'game'])
            ),
        ]);
    }

    public function claim(Request $request, Key $key): RedirectResponse
    {
        $this->authorize('claim', $key);

        $key->claim(auth()->user());

        return back()->with('message', __('keys.claimsuccess'));
    }

    public function claimed(Request $request): Response
    {
        return Inertia::render('Keys/Claimed', [
            'games' => Inertia::scroll(fn (): \Spatie\LaravelData\DataCollection|\Spatie\LaravelData\PaginatedDataCollection|\Spatie\LaravelData\CursorPaginatedDataCollection|\Illuminate\Support\Enumerable|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Contracts\Pagination\CursorPaginator|array => GameData::collect(
                auth()
                    ->user()
                    ->claimedKeys()
                    ->with('game')
                    ->paginate(12)
            )),
        ]);
    }

    public function shared(Request $request): Response
    {
        return Inertia::render('Keys/Shared', [
            'games' => Inertia::scroll(fn (): \Spatie\LaravelData\DataCollection|\Spatie\LaravelData\PaginatedDataCollection|\Spatie\LaravelData\CursorPaginatedDataCollection|\Illuminate\Support\Enumerable|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Contracts\Pagination\CursorPaginator|array => GameData::collect(
                auth()
                    ->user()
                    ->sharedKeys()
                    ->with('game')
                    ->paginate(12)
            )),
        ]);
    }
}
