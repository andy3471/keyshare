<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\GroupRole;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_groups_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/groups');

        $response->assertOk();
    }

    public function test_guest_cannot_view_groups(): void
    {
        $response = $this->get('/groups');

        $response->assertRedirect('/login');
    }

    public function test_user_can_create_group(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/groups', [
            'name'        => 'Test Group',
            'description' => 'A test group',
            'is_public'   => true,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('groups', [
            'name'      => 'Test Group',
            'owner_id'  => $user->id,
            'is_public' => true,
        ]);

        $group = Group::where('name', 'Test Group')->first();
        $this->assertTrue($group->hasMember($user));
        $this->assertEquals(GroupRole::Owner, $group->memberRole($user));
    }

    public function test_user_can_view_own_group(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $user->id]);
        $group->addMember($user, GroupRole::Owner);

        $response = $this->actingAs($user)->get("/groups/{$group->id}");

        $response->assertOk();
    }

    public function test_user_can_view_public_group(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->public()->create();

        $response = $this->actingAs($user)->get("/groups/{$group->id}");

        $response->assertOk();
    }

    public function test_user_cannot_view_private_group_they_are_not_member_of(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->private()->create();

        $response = $this->actingAs($user)->get("/groups/{$group->id}");

        $response->assertForbidden();
    }

    public function test_user_can_join_public_group(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->public()->create();

        $response = $this->actingAs($user)->post("/groups/{$group->id}/join");

        $response->assertRedirect();

        $this->assertTrue($group->hasMember($user));
        $this->assertEquals(GroupRole::Member, $group->memberRole($user));
    }

    public function test_user_cannot_join_private_group(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->private()->create();

        $response = $this->actingAs($user)->post("/groups/{$group->id}/join");

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertFalse($group->hasMember($user));
    }

    public function test_user_can_join_via_invite_code(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->private()->create();

        $response = $this->actingAs($user)->get("/invite/{$group->invite_code}");

        $response->assertRedirect();
        $this->assertTrue($group->fresh()->hasMember($user));
    }

    public function test_member_can_leave_group(): void
    {
        $owner  = User::factory()->create();
        $member = User::factory()->create();
        $group  = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($member, GroupRole::Member);

        $response = $this->actingAs($member)->post("/groups/{$group->id}/leave");

        $response->assertRedirect();
        $this->assertFalse($group->fresh()->hasMember($member));
    }

    public function test_owner_cannot_leave_group(): void
    {
        $owner = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);

        $response = $this->actingAs($owner)->post("/groups/{$group->id}/leave");

        $response->assertForbidden();
        $this->assertTrue($group->fresh()->hasMember($owner));
    }

    public function test_owner_can_update_group(): void
    {
        $owner = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);

        $response = $this->actingAs($owner)->put("/groups/{$group->id}", [
            'name'        => 'Updated Name',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('groups', [
            'id'          => $group->id,
            'name'        => 'Updated Name',
            'description' => 'Updated description',
        ]);
    }

    public function test_member_cannot_update_group(): void
    {
        $owner  = User::factory()->create();
        $member = User::factory()->create();
        $group  = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($member, GroupRole::Member);

        $response = $this->actingAs($member)->put("/groups/{$group->id}", [
            'name' => 'Hacked Name',
        ]);

        $response->assertForbidden();
    }

    public function test_owner_can_delete_group(): void
    {
        $owner = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);

        $response = $this->actingAs($owner)->delete("/groups/{$group->id}");

        $response->assertRedirect('/groups');
        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
    }

    public function test_non_owner_cannot_delete_group(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($admin, GroupRole::Admin);

        $response = $this->actingAs($admin)->delete("/groups/{$group->id}");

        $response->assertForbidden();
    }

    public function test_admin_can_remove_member(): void
    {
        $owner  = User::factory()->create();
        $admin  = User::factory()->create();
        $member = User::factory()->create();
        $group  = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($admin, GroupRole::Admin);
        $group->addMember($member, GroupRole::Member);

        $response = $this->actingAs($admin)->delete("/groups/{$group->id}/members/{$member->id}");

        $response->assertRedirect();
        $this->assertFalse($group->fresh()->hasMember($member));
    }

    public function test_cannot_remove_group_owner(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($admin, GroupRole::Admin);

        $response = $this->actingAs($admin)->delete("/groups/{$group->id}/members/{$owner->id}");

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertTrue($group->fresh()->hasMember($owner));
    }

    public function test_user_can_switch_active_group(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $user->id]);
        $group->addMember($user, GroupRole::Owner);

        $response = $this->actingAs($user)->post('/groups/switch', [
            'group_id' => $group->id,
        ]);

        $response->assertRedirect();
        $this->assertEquals($group->id, session('active_group_id'));
    }

    public function test_user_can_clear_active_group(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $user->id]);
        $group->addMember($user, GroupRole::Owner);

        session(['active_group_id' => $group->id]);

        $response = $this->actingAs($user)->post('/groups/switch', [
            'group_id' => null,
        ]);

        $response->assertRedirect();
        $this->assertNull(session('active_group_id'));
    }

    public function test_owner_can_regenerate_invite_code(): void
    {
        $owner    = User::factory()->create();
        $group    = Group::factory()->create(['owner_id' => $owner->id]);
        $oldCode  = $group->invite_code;
        $group->addMember($owner, GroupRole::Owner);

        $response = $this->actingAs($owner)->post("/groups/{$group->id}/regenerate-invite-code");

        $response->assertRedirect();
        $this->assertNotEquals($oldCode, $group->fresh()->invite_code);
    }

    public function test_group_requires_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/groups', [
            'name'        => '',
            'description' => 'A description',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_member_can_view_key_in_their_group(): void
    {
        $owner  = User::factory()->create();
        $member = User::factory()->create();
        $group  = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($member, GroupRole::Member);

        $key = $this->createKey(['group_id' => $group->id]);

        $this->assertTrue($member->isMemberOf($group));
        $this->actingAs($member);
        $this->assertTrue($member->can('view', $key));
    }

    public function test_non_member_cannot_view_key_in_group(): void
    {
        $owner    = User::factory()->create();
        $outsider = User::factory()->create();
        $group    = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);

        $key = $this->createKey(['group_id' => $group->id]);

        $this->actingAs($outsider);
        $this->assertFalse($outsider->can('view', $key));
    }

    public function test_non_member_cannot_claim_key_in_group(): void
    {
        $owner    = User::factory()->create();
        $outsider = User::factory()->create();
        $group    = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);

        $key = $this->createKey(['group_id' => $group->id]);

        $this->actingAs($outsider);
        $this->assertFalse($outsider->can('claim', $key));
    }

    public function test_member_can_claim_unclaimed_key_in_their_group(): void
    {
        $owner  = User::factory()->create();
        $member = User::factory()->create();
        $group  = Group::factory()->create(['owner_id' => $owner->id]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($member, GroupRole::Member);

        $key = $this->createKey([
            'group_id'      => $group->id,
            'owned_user_id' => null,
        ]);

        $this->actingAs($member);
        $this->assertTrue($member->can('claim', $key));
    }

    public function test_cannot_create_key_without_any_groups(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertFalse($user->can('create', Key::class));
    }

    public function test_can_create_key_when_member_of_a_group(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $user->id]);
        $group->addMember($user, GroupRole::Owner);

        $this->actingAs($user);

        $this->assertTrue($user->can('create', Key::class));
    }

    private function createKey(array $attributes = []): Key
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
}
