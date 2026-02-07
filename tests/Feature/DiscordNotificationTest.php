<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\GroupRole;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use App\Notifications\KeyAdded;
use App\Notifications\KeyClaimed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DiscordNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_group_with_webhook_is_notified_when_key_added(): void
    {
        Notification::fake();

        $user  = User::factory()->create();
        $group = Group::factory()->create([
            'owner_id'            => $user->id,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
        ]);
        $group->addMember($user, GroupRole::Owner);

        $game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
        $platform = Platform::create(['name' => 'Steam']);

        $this->actingAs($user)->post('/keys', [
            'platform_id' => $platform->id,
            'key'         => 'XXXX-YYYY-ZZZZ',
            'igdb_id'     => $game->igdb_id,
            'group_id'    => $group->id,
        ]);

        Notification::assertSentTo($group, KeyAdded::class);
    }

    public function test_group_without_webhook_is_not_notified_when_key_added(): void
    {
        Notification::fake();

        $user  = User::factory()->create();
        $group = Group::factory()->create([
            'owner_id'            => $user->id,
            'discord_webhook_url' => null,
        ]);
        $group->addMember($user, GroupRole::Owner);

        $game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
        $platform = Platform::create(['name' => 'Steam']);

        $this->actingAs($user)->post('/keys', [
            'platform_id' => $platform->id,
            'key'         => 'XXXX-YYYY-ZZZZ',
            'igdb_id'     => $game->igdb_id,
            'group_id'    => $group->id,
        ]);

        Notification::assertNotSentTo($group, KeyAdded::class);
    }

    public function test_group_with_webhook_is_notified_when_key_claimed(): void
    {
        Notification::fake();

        $owner   = User::factory()->create();
        $claimer = User::factory()->create();
        $group   = Group::factory()->create([
            'owner_id'            => $owner->id,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
        ]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($claimer, GroupRole::Member);

        $game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
        $platform = Platform::create(['name' => 'Steam']);

        $key = Key::create([
            'game_id'         => $game->id,
            'platform_id'     => $platform->id,
            'key'             => 'XXXX-YYYY-ZZZZ',
            'created_user_id' => $owner->id,
            'group_id'        => $group->id,
        ]);

        $this->actingAs($claimer)->post("/keys/{$key->id}/claim");

        Notification::assertSentTo($group, KeyClaimed::class);
    }

    public function test_group_without_webhook_is_not_notified_when_key_claimed(): void
    {
        Notification::fake();

        $owner   = User::factory()->create();
        $claimer = User::factory()->create();
        $group   = Group::factory()->create([
            'owner_id'            => $owner->id,
            'discord_webhook_url' => null,
        ]);
        $group->addMember($owner, GroupRole::Owner);
        $group->addMember($claimer, GroupRole::Member);

        $game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
        $platform = Platform::create(['name' => 'Steam']);

        $key = Key::create([
            'game_id'         => $game->id,
            'platform_id'     => $platform->id,
            'key'             => 'XXXX-YYYY-ZZZZ',
            'created_user_id' => $owner->id,
            'group_id'        => $group->id,
        ]);

        $this->actingAs($claimer)->post("/keys/{$key->id}/claim");

        Notification::assertNotSentTo($group, KeyClaimed::class);
    }

    public function test_key_added_notification_contains_user_and_platform_info(): void
    {
        $user     = User::factory()->create(['name' => 'TestUser']);
        $game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
        $platform = Platform::create(['name' => 'Steam']);
        $group    = Group::factory()->create([
            'owner_id'            => $user->id,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
        ]);

        $key = Key::create([
            'game_id'         => $game->id,
            'platform_id'     => $platform->id,
            'key'             => 'XXXX-YYYY-ZZZZ',
            'created_user_id' => $user->id,
            'group_id'        => $group->id,
        ]);

        $notification = new KeyAdded($key, $user, $game);
        $payload      = $notification->toDiscordWebhook($group);

        $this->assertArrayHasKey('content', $payload);
        $this->assertStringContainsString('TestUser', $payload['content']);
        $this->assertStringContainsString('Steam', $payload['content']);
        $this->assertStringContainsString('shared a key', $payload['content']);
    }

    public function test_key_claimed_notification_contains_user_and_platform_info(): void
    {
        $claimer  = User::factory()->create(['name' => 'Claimer']);
        $game     = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);
        $platform = Platform::create(['name' => 'GOG']);
        $group    = Group::factory()->create([
            'owner_id'            => $claimer->id,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
        ]);

        $key = Key::create([
            'game_id'         => $game->id,
            'platform_id'     => $platform->id,
            'key'             => 'XXXX-YYYY-ZZZZ',
            'created_user_id' => $claimer->id,
            'group_id'        => $group->id,
        ]);

        $notification = new KeyClaimed($key, $claimer, $game);
        $payload      = $notification->toDiscordWebhook($group);

        $this->assertArrayHasKey('content', $payload);
        $this->assertStringContainsString('Claimer', $payload['content']);
        $this->assertStringContainsString('GOG', $payload['content']);
        $this->assertStringContainsString('claimed a key', $payload['content']);
    }

    public function test_owner_can_update_group_discord_webhook_url(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $user->id]);
        $group->addMember($user, GroupRole::Owner);

        $response = $this->actingAs($user)->put("/groups/{$group->id}", [
            'name'                => $group->name,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123456/abcdef',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('groups', [
            'id'                  => $group->id,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123456/abcdef',
        ]);
    }

    public function test_owner_can_clear_discord_webhook_url(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->create([
            'owner_id'            => $user->id,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
        ]);
        $group->addMember($user, GroupRole::Owner);

        $response = $this->actingAs($user)->put("/groups/{$group->id}", [
            'name'                => $group->name,
            'discord_webhook_url' => '',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('groups', [
            'id'                  => $group->id,
            'discord_webhook_url' => null,
        ]);
    }

    public function test_invalid_discord_webhook_url_is_rejected(): void
    {
        $user  = User::factory()->create();
        $group = Group::factory()->create(['owner_id' => $user->id]);
        $group->addMember($user, GroupRole::Owner);

        $response = $this->actingAs($user)->put("/groups/{$group->id}", [
            'name'                => $group->name,
            'discord_webhook_url' => 'https://evil.com/webhook',
        ]);

        $response->assertSessionHasErrors('discord_webhook_url');
    }

    public function test_has_discord_webhook_returns_correctly(): void
    {
        $group = Group::factory()->create([
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
        ]);
        $this->assertTrue($group->hasDiscordWebhook());

        $groupWithout = Group::factory()->create([
            'discord_webhook_url' => null,
        ]);
        $this->assertFalse($groupWithout->hasDiscordWebhook());
    }
}
