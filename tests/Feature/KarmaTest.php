<?php

declare(strict_types=1);

use App\Enums\KeyFeedback;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use App\Services\KarmaService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

beforeEach(function (): void {
    $this->karmaService = resolve(KarmaService::class);
    $this->game         = Game::create(['igdb_id' => 1]);
    $this->platform     = Platform::create(['name' => 'Steam']);
});

it('gives a new user zero karma', function (): void {
    $user = User::factory()->create();

    expect($this->karmaService->getKarma($user))->toBe(0);
});

it('does not give karma when sharing a key', function (): void {
    $sharer = User::factory()->create();

    Key::factory()->create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'created_user_id' => $sharer->id,
        'owned_user_id'   => null,
    ]);

    $this->karmaService->recalculateKarma($sharer);

    expect($this->karmaService->getKarma($sharer))->toBe(0);
});

it('gives karma to sharer when key is claimed', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    expect($this->karmaService->getKarma($sharer))->toBe(1);
});

it('costs the claimer 1 karma when claiming', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    expect($this->karmaService->getKarma($claimer))->toBe(-1);
});

it('does not refund claimer karma on negative feedback', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);
    $key->update(['feedback' => KeyFeedback::DidNotWork]);

    expect($this->karmaService->getKarma($claimer))->toBe(-1);
});

it('prevents claiming your own key', function (): void {
    $sharer = User::factory()->create();
    $group  = createGroupWithMembers($sharer);

    $key = createKey($sharer, $group, $this->game, $this->platform);

    $this->actingAs($sharer);

    expect(Gate::allows('claim', $key))->toBeFalse();
});

it('revokes sharer karma on negative feedback', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    expect($this->karmaService->getKarma($sharer))->toBe(1);

    $key->update(['feedback' => KeyFeedback::DidNotWork]);

    expect($this->karmaService->getKarma($sharer))->toBe(0);
});

it('keeps sharer karma on positive feedback', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);
    $key->update(['feedback' => KeyFeedback::Worked]);

    expect($this->karmaService->getKarma($sharer))->toBe(1);
});

it('restores karma when negative feedback is reversed', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    expect($this->karmaService->getKarma($sharer))->toBe(1);

    $key->update(['feedback' => KeyFeedback::DidNotWork]);
    expect($this->karmaService->getKarma($sharer))->toBe(0);

    $key->update(['feedback' => KeyFeedback::Worked]);
    expect($this->karmaService->getKarma($sharer))->toBe(1);
});

it('returns correct colour for karma thresholds', function (): void {
    expect(KarmaService::colour(-1))->toBe('bg-danger text-white shadow-danger/30')
        ->and(KarmaService::colour(0))->toBe('bg-warning text-white shadow-warning/30')
        ->and(KarmaService::colour(1))->toBe('bg-warning text-white shadow-warning/30')
        ->and(KarmaService::colour(2))->toBe('bg-primary-600 text-white shadow-primary-600/30')
        ->and(KarmaService::colour(14))->toBe('bg-primary-600 text-white shadow-primary-600/30')
        ->and(KarmaService::colour(15))->toBe('bg-success text-white shadow-success/30')
        ->and(KarmaService::colour(100))->toBe('bg-success text-white shadow-success/30');
});

it('caches karma values', function (): void {
    $user = User::factory()->create();

    Cache::flush();

    $this->karmaService->getKarma($user);

    expect(Cache::has('karma:user:'.$user->id))->toBeTrue();
});

it('recalculates karma for all users', function (): void {
    $users = User::factory(3)->create();

    $this->karmaService->recalculateAll();

    foreach ($users as $user) {
        expect(Cache::has('karma:user:'.$user->id))->toBeTrue();
    }
});

it('allows claimer to submit positive feedback', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    $this->actingAs($claimer);

    expect(Gate::allows('feedback', $key))->toBeTrue();

    $key->update(['feedback' => KeyFeedback::Worked]);

    expect($key->fresh()->feedback)->toBe(KeyFeedback::Worked)
        ->and($this->karmaService->getKarma($sharer))->toBe(1);
});

it('allows claimer to submit negative feedback', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    $this->actingAs($claimer);

    $key->update(['feedback' => KeyFeedback::DidNotWork]);

    expect($key->fresh()->feedback)->toBe(KeyFeedback::DidNotWork)
        ->and($this->karmaService->getKarma($sharer))->toBe(0);
});

it('denies feedback from non-claimer', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $other   = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer, $other);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    $this->actingAs($other);

    expect(Gate::allows('feedback', $key))->toBeFalse();
});

it('only allows the claimer to give feedback', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $key = createKey($sharer, $group, $this->game, $this->platform);
    $key->claim($claimer);

    $this->actingAs($claimer);
    expect(Gate::allows('feedback', $key))->toBeTrue();

    $this->actingAs($sharer);
    expect(Gate::allows('feedback', $key))->toBeFalse();
});

it('accumulates karma from multiple claimed keys', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    for ($i = 0; $i < 3; $i++) {
        $key = createKey($sharer, $group, $this->game, $this->platform);
        $key->claim($claimer);
    }

    expect($this->karmaService->getKarma($sharer))->toBe(3);
});

it('blocks claim when karma is below group minimum', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $group->update(['min_karma' => 5]);

    $key = createKey($sharer, $group, $this->game, $this->platform);

    $this->actingAs($claimer);

    expect(Gate::allows('claim', $key))->toBeFalse();
});

it('allows claim when karma meets group minimum', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $group->update(['min_karma' => 0]);

    $key = createKey($sharer, $group, $this->game, $this->platform);

    $this->actingAs($claimer);

    expect(Gate::allows('claim', $key))->toBeTrue();
});

it('allows claim when group has no minimum karma', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $group->update(['min_karma' => null]);

    $key = createKey($sharer, $group, $this->game, $this->platform);

    $this->actingAs($claimer);

    expect(Gate::allows('claim', $key))->toBeTrue();
});

it('blocks claim at negative karma threshold for very low karma', function (): void {
    $sharer  = User::factory()->create();
    $claimer = User::factory()->create();
    $group   = createGroupWithMembers($sharer, $claimer);

    $group->update(['min_karma' => -2]);

    $key = createKey($sharer, $group, $this->game, $this->platform);

    $this->actingAs($claimer);

    expect(Gate::allows('claim', $key))->toBeTrue();
});

// --- Helpers ---

function createGroupWithMembers(User ...$users): Group
{
    $owner = $users[0];
    $group = Group::factory()->create(['owner_id' => $owner->id]);

    foreach ($users as $user) {
        $group->addMember($user);
    }

    return $group;
}

function createKey(User $sharer, Group $group, Game $game, Platform $platform): Key
{
    return Key::factory()->create([
        'game_id'         => $game->id,
        'platform_id'     => $platform->id,
        'created_user_id' => $sharer->id,
        'owned_user_id'   => null,
        'group_id'        => $group->id,
    ]);
}
