<?php

declare(strict_types=1);

namespace App\Http\Controllers\Keys;

use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Keys\KeyData;
use App\DataTransferObjects\Platforms\PlatformData;
use App\DataTransferObjects\Search\AutocompleteGameData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameKeyRequest;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class KeyController extends Controller
{
    public function create(Request $request): Response
    {
        $user          = auth()->user();
        $activeGroupId = session('active_group_id');
        $canCreate     = $user->can('create', Key::class);

        return Inertia::render('Keys/Create', [
            'canCreate' => $canCreate,
            'platforms' => fn (): Collection => PlatformData::collect(Cache::remember('platforms', 3600, function () {
                return Platform::all();
            })),
            'game'          => fn (): ?AutocompleteGameData => $request->filled('game_id') ? AutocompleteGameData::fromIgdbId((int) $request->string('game_id')->toString()) : null,
            'groups'        => fn () => $user->groups()->withCount('members')->with('media')->get()->map(fn (Group $group): GroupData => GroupData::fromModel($group)),
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

        auth()
            ->user()
            ->sharedKeys()
            ->create(array_merge(
                $request->validated(),
                [
                    'game_id'  => $game->id,
                    'group_id' => $group->id,
                ]
            ));

        return back()->with('message', __('keys.added'));
    }

    public function show(Key $key): Response
    {
        $key->load(['platform', 'createdUser.media', 'claimedUser.media', 'game', 'group.media']);
        auth()->user()->loadMissing(['media', 'groups']);

        $this->authorize('view', $key);

        return Inertia::render('Keys/Show', [
            'keyData' => fn (): KeyData => KeyData::fromModel($key),
        ]);
    }

    public function destroy(Key $key): RedirectResponse
    {
        $this->authorize('delete', $key);

        $gameIgdbId = $key->game?->igdb_id;

        $key->delete();

        if ($gameIgdbId) {
            return to_route('games.show', ['igdb_id' => $gameIgdbId])
                ->with('message', __('keys.deleted'));
        }

        return to_route('games.index')->with('message', __('keys.deleted'));
    }
}
