<?php

declare(strict_types=1);

use App\Enums\ClaimDeniedReason;
use App\Enums\GroupRole;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use App\Policies\KeyPolicy;

beforeEach(function (): void {
    $this->owner    = User::factory()->create();
    $this->claimer  = User::factory()->create();
    $this->game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
    $this->platform = Platform::create(['name' => 'Steam']);
});

it('allows claiming when no cooldown is set on the group', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => null,
    ]);
    $group->addMember($this->owner, GroupRole::Owner);
    $group->addMember($this->claimer, GroupRole::Member);

    // Claimer already claimed a key in this group
    $previousKey = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'PREV-KEY-1111',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);
    $previousKey->claim($this->claimer);

    $newKey = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'NEW-KEY-2222',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);

    $policy = new KeyPolicy;

    expect($policy->claimDeniedReason($this->claimer, $newKey))->toBeNull();
});

it('denies claiming when cooldown is active', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => 60,
    ]);
    $group->addMember($this->owner, GroupRole::Owner);
    $group->addMember($this->claimer, GroupRole::Member);

    $previousKey = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'PREV-KEY-1111',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);
    $previousKey->claim($this->claimer);

    $newKey = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'NEW-KEY-2222',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);

    $policy = new KeyPolicy;

    expect($policy->claimDeniedReason($this->claimer, $newKey))->toBe(ClaimDeniedReason::CooldownActive);
});

it('allows claiming after cooldown expires', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => 30,
    ]);
    $group->addMember($this->owner, GroupRole::Owner);
    $group->addMember($this->claimer, GroupRole::Member);

    $previousKey = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'PREV-KEY-1111',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);
    $previousKey->claim($this->claimer);

    // Simulate the claim happened 31 minutes ago
    Illuminate\Support\Facades\DB::table('keys')
        ->where('id', $previousKey->id)
        ->update(['updated_at' => now()->subMinutes(31)]);

    $newKey = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'NEW-KEY-2222',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);

    $policy = new KeyPolicy;

    expect($policy->claimDeniedReason($this->claimer, $newKey))->toBeNull();
});

it('scopes cooldown per group', function (): void {
    $groupA = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => 60,
    ]);
    $groupA->addMember($this->owner, GroupRole::Owner);
    $groupA->addMember($this->claimer, GroupRole::Member);

    $groupB = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => 60,
    ]);
    $groupB->addMember($this->owner, GroupRole::Owner);
    $groupB->addMember($this->claimer, GroupRole::Member);

    // Claim a key in group A
    $keyA = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'KEY-GROUP-A',
        'created_user_id' => $this->owner->id,
        'group_id'        => $groupA->id,
    ]);
    $keyA->claim($this->claimer);

    // Should still be able to claim in group B
    $keyB = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'KEY-GROUP-B',
        'created_user_id' => $this->owner->id,
        'group_id'        => $groupB->id,
    ]);

    $policy = new KeyPolicy;

    expect($policy->claimDeniedReason($this->claimer, $keyB))->toBeNull();
});

it('allows first claim in a group with cooldown', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => 60,
    ]);
    $group->addMember($this->owner, GroupRole::Owner);
    $group->addMember($this->claimer, GroupRole::Member);

    $key = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'FIRST-KEY-1111',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);

    $policy = new KeyPolicy;

    expect($policy->claimDeniedReason($this->claimer, $key))->toBeNull();
});

it('returns correct cooldown end time', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => 60,
    ]);
    $group->addMember($this->owner, GroupRole::Owner);
    $group->addMember($this->claimer, GroupRole::Member);

    $previousKey = Key::create([
        'game_id'         => $this->game->id,
        'platform_id'     => $this->platform->id,
        'key'             => 'PREV-KEY-1111',
        'created_user_id' => $this->owner->id,
        'group_id'        => $group->id,
    ]);
    $previousKey->claim($this->claimer);

    $policy = new KeyPolicy;
    $endsAt = $policy->cooldownEndsAt($this->claimer, $group);

    expect($endsAt)->not->toBeNull();
    expect($endsAt->isFuture())->toBeTrue();
    expect($endsAt->diffInMinutes(now(), true))->toBeLessThanOrEqual(60);
});

it('returns null cooldown end time when no cooldown is set', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => null,
    ]);

    $policy = new KeyPolicy;

    expect($policy->cooldownEndsAt($this->claimer, $group))->toBeNull();
});

it('persists claim_cooldown_minutes on the group model', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => 120,
    ]);

    expect($group->fresh()->claim_cooldown_minutes)->toBe(120);
});

it('allows null claim_cooldown_minutes', function (): void {
    $group = Group::factory()->create([
        'owner_id'               => $this->owner->id,
        'claim_cooldown_minutes' => null,
    ]);

    expect($group->fresh()->claim_cooldown_minutes)->toBeNull();
});

it('includes claim_cooldown_minutes in validation rules', function (): void {
    $request = new App\Http\Requests\Groups\UpdateGroupRequest;
    $rules   = $request->rules();

    expect($rules)->toHaveKey('claim_cooldown_minutes');
    expect($rules['claim_cooldown_minutes'])->toContain('nullable');
    expect($rules['claim_cooldown_minutes'])->toContain('integer');
    expect($rules['claim_cooldown_minutes'])->toContain('min:1');
});
