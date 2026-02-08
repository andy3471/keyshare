<?php

declare(strict_types=1);

use App\Enums\GroupRole;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;

it('lets a user view the groups index', function (): void {
    $this->actingAs(User::factory()->create())
        ->get('/groups')
        ->assertOk();
});

it('redirects guests away from groups', function (): void {
    $this->get('/groups')
        ->assertRedirect('/login');
});

it('lets a user create a group', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/groups', [
        'name'        => 'Test Group',
        'description' => 'A test group',
        'is_public'   => true,
    ])->assertRedirect();

    $this->assertDatabaseHas('groups', [
        'name'      => 'Test Group',
        'owner_id'  => $user->id,
        'is_public' => true,
    ]);

    $group = Group::where('name', 'Test Group')->first();
    $user  = $user->fresh();

    expect($group->hasMember($user))->toBeTrue()
        ->and($group->memberRole($user))->toBe(GroupRole::Owner);
});

it('lets a user view their own group', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $user->id]);
    $group->addMember($user, GroupRole::Owner);

    $this->actingAs($user)
        ->get("/groups/{$group->id}")
        ->assertOk();
});

it('lets a user view a public group', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->public()->create();

    $this->actingAs($user)
        ->get("/groups/{$group->id}")
        ->assertOk();
});

it('forbids a user from viewing a private group they are not in', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->private()->create();

    $this->actingAs($user)
        ->get("/groups/{$group->id}")
        ->assertForbidden();
});

it('lets a user join a public group', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->public()->create();

    $this->actingAs($user)
        ->post("/groups/{$group->id}/join")
        ->assertRedirect();

    expect($group->fresh()->hasMember($user->fresh()))->toBeTrue()
        ->and($group->fresh()->memberRole($user->fresh()))->toBe(GroupRole::Member);
});

it('prevents a user from joining a private group', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->private()->create();

    $this->actingAs($user)
        ->post("/groups/{$group->id}/join")
        ->assertRedirect()
        ->assertSessionHas('error');

    expect($group->fresh()->hasMember($user->fresh()))->toBeFalse();
});

it('lets a user join via invite code', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->private()->create();

    $this->actingAs($user)
        ->get("/invite/{$group->invite_code}")
        ->assertRedirect();

    expect($group->fresh()->hasMember($user->fresh()))->toBeTrue();
});

it('lets a member leave a group', function (): void {
    $owner  = User::factory()->create();
    $member = User::factory()->create();
    $group  = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);
    $group->addMember($member, GroupRole::Member);

    $this->actingAs($member)
        ->post("/groups/{$group->id}/leave")
        ->assertRedirect();

    expect($group->fresh()->hasMember($member->fresh()))->toBeFalse();
});

it('prevents an owner from leaving their group', function (): void {
    $owner = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);

    $this->actingAs($owner)
        ->post("/groups/{$group->id}/leave")
        ->assertForbidden();

    expect($group->fresh()->hasMember($owner->fresh()))->toBeTrue();
});

it('lets an owner update the group', function (): void {
    $owner = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);

    $this->actingAs($owner)
        ->put("/groups/{$group->id}", [
            'name'        => 'Updated Name',
            'description' => 'Updated description',
        ])->assertRedirect();

    $this->assertDatabaseHas('groups', [
        'id'          => $group->id,
        'name'        => 'Updated Name',
        'description' => 'Updated description',
    ]);
});

it('prevents a member from updating the group', function (): void {
    $owner  = User::factory()->create();
    $member = User::factory()->create();
    $group  = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);
    $group->addMember($member, GroupRole::Member);

    $this->actingAs($member)
        ->put("/groups/{$group->id}", ['name' => 'Hacked Name'])
        ->assertForbidden();
});

it('lets an owner delete the group', function (): void {
    $owner = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);

    $this->actingAs($owner)
        ->delete("/groups/{$group->id}")
        ->assertRedirect('/groups');

    $this->assertDatabaseMissing('groups', ['id' => $group->id]);
});

it('prevents a non-owner from deleting the group', function (): void {
    $owner = User::factory()->create();
    $admin = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);
    $group->addMember($admin, GroupRole::Admin);

    $this->actingAs($admin)
        ->delete("/groups/{$group->id}")
        ->assertForbidden();
});

it('lets an admin remove a member', function (): void {
    $owner  = User::factory()->create();
    $admin  = User::factory()->create();
    $member = User::factory()->create();
    $group  = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);
    $group->addMember($admin, GroupRole::Admin);
    $group->addMember($member, GroupRole::Member);

    $this->actingAs($admin)
        ->delete("/groups/{$group->id}/members/{$member->id}")
        ->assertRedirect();

    expect($group->fresh()->hasMember($member->fresh()))->toBeFalse();
});

it('prevents removing the group owner', function (): void {
    $owner = User::factory()->create();
    $admin = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);
    $group->addMember($admin, GroupRole::Admin);

    $this->actingAs($admin)
        ->delete("/groups/{$group->id}/members/{$owner->id}")
        ->assertRedirect()
        ->assertSessionHas('error');

    expect($group->fresh()->hasMember($owner->fresh()))->toBeTrue();
});

it('lets a user switch their active group', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $user->id]);
    $group->addMember($user, GroupRole::Owner);

    $this->actingAs($user)
        ->post('/groups/switch', ['group_id' => $group->id])
        ->assertRedirect();

    expect(session('active_group_id'))->toBe($group->id);
});

it('lets a user clear their active group', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $user->id]);
    $group->addMember($user, GroupRole::Owner);

    session(['active_group_id' => $group->id]);

    $this->actingAs($user)
        ->post('/groups/switch', ['group_id' => null])
        ->assertRedirect();

    expect(session('active_group_id'))->toBeNull();
});

it('lets an owner regenerate the invite code', function (): void {
    $owner   = User::factory()->create();
    $group   = Group::factory()->create(['owner_id' => $owner->id]);
    $oldCode = $group->invite_code;
    $group->addMember($owner, GroupRole::Owner);

    $this->actingAs($owner)
        ->post("/groups/{$group->id}/regenerate-invite-code")
        ->assertRedirect();

    expect($group->fresh()->invite_code)->not->toBe($oldCode);
});

it('requires a name when creating a group', function (): void {
    $this->actingAs(User::factory()->create())
        ->post('/groups', [
            'name'        => '',
            'description' => 'A description',
        ])->assertSessionHasErrors('name');
});

it('lets a member view a key in their group', function (): void {
    $owner  = User::factory()->create();
    $member = User::factory()->create();
    $group  = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);
    $group->addMember($member, GroupRole::Member);

    $key = createTestKey(['group_id' => $group->id]);

    expect($member->isMemberOf($group))->toBeTrue();

    $this->actingAs($member);

    expect($member->can('view', $key))->toBeTrue();
});

it('prevents a non-member from viewing a key in a group', function (): void {
    $owner    = User::factory()->create();
    $outsider = User::factory()->create();
    $group    = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);

    $key = createTestKey(['group_id' => $group->id]);

    $this->actingAs($outsider);

    expect($outsider->can('view', $key))->toBeFalse();
});

it('prevents a non-member from claiming a key in a group', function (): void {
    $owner    = User::factory()->create();
    $outsider = User::factory()->create();
    $group    = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);

    $key = createTestKey(['group_id' => $group->id]);

    $this->actingAs($outsider);

    expect($outsider->can('claim', $key))->toBeFalse();
});

it('lets a member claim an unclaimed key in their group', function (): void {
    $owner  = User::factory()->create();
    $member = User::factory()->create();
    $group  = Group::factory()->create(['owner_id' => $owner->id]);
    $group->addMember($owner, GroupRole::Owner);
    $group->addMember($member, GroupRole::Member);

    $key = createTestKey([
        'group_id'      => $group->id,
        'owned_user_id' => null,
    ]);

    $this->actingAs($member);

    expect($member->can('claim', $key))->toBeTrue();
});

it('prevents key creation without any groups', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    expect($user->can('create', Key::class))->toBeFalse();
});

it('allows key creation when member of a group', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $user->id]);
    $group->addMember($user, GroupRole::Owner);

    $this->actingAs($user);

    expect($user->can('create', Key::class))->toBeTrue();
});

// --- Helpers ---

function createTestKey(array $attributes = []): Key
{
    $game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
    $platform = Platform::create(['name' => fake()->word()]);

    return Key::create(array_merge([
        'game_id'         => $game->id,
        'platform_id'     => $platform->id,
        'key'             => fake()->uuid(),
        'created_user_id' => User::factory()->create()->id,
        'owned_user_id'   => null,
        'group_id'        => null,
        'message'         => fake()->sentence(),
    ], $attributes));
}
