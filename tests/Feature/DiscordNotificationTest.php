<?php

declare(strict_types=1);

use App\Enums\GroupRole;
use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use App\Notifications\KeyAdded;
use App\Notifications\KeyClaimed;
use Illuminate\Support\Facades\Notification;

it('notifies a group with webhook when a key is added', function (): void {
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
});

it('does not notify a group without webhook when a key is added', function (): void {
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
});

it('notifies a group with webhook when a key is claimed', function (): void {
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
});

it('does not notify a group without webhook when a key is claimed', function (): void {
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
});

it('includes user and platform info in key added notification', function (): void {
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

    expect($payload)
        ->toHaveKey('content')
        ->and($payload['content'])->toContain('TestUser')
        ->and($payload['content'])->toContain('Steam')
        ->and($payload['content'])->toContain('shared a key');
});

it('includes user and platform info in key claimed notification', function (): void {
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

    expect($payload)
        ->toHaveKey('content')
        ->and($payload['content'])->toContain('Claimer')
        ->and($payload['content'])->toContain('GOG')
        ->and($payload['content'])->toContain('claimed a key');
});

it('lets an owner update the group discord webhook url', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $user->id]);
    $group->addMember($user, GroupRole::Owner);

    $this->actingAs($user)
        ->put("/groups/{$group->id}", [
            'name'                => $group->name,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123456/abcdef',
        ])->assertRedirect();

    $this->assertDatabaseHas('groups', [
        'id'                  => $group->id,
        'discord_webhook_url' => 'https://discord.com/api/webhooks/123456/abcdef',
    ]);
});

it('lets an owner clear the discord webhook url', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->create([
        'owner_id'            => $user->id,
        'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
    ]);
    $group->addMember($user, GroupRole::Owner);

    $this->actingAs($user)
        ->put("/groups/{$group->id}", [
            'name'                => $group->name,
            'discord_webhook_url' => '',
        ])->assertRedirect();

    $this->assertDatabaseHas('groups', [
        'id'                  => $group->id,
        'discord_webhook_url' => null,
    ]);
});

it('rejects an invalid discord webhook url', function (): void {
    $user  = User::factory()->create();
    $group = Group::factory()->create(['owner_id' => $user->id]);
    $group->addMember($user, GroupRole::Owner);

    $this->actingAs($user)
        ->put("/groups/{$group->id}", [
            'name'                => $group->name,
            'discord_webhook_url' => 'https://evil.com/webhook',
        ])->assertSessionHasErrors('discord_webhook_url');
});

it('correctly reports whether a group has a discord webhook', function (): void {
    $group = Group::factory()->create([
        'discord_webhook_url' => 'https://discord.com/api/webhooks/123/abc',
    ]);

    expect($group->hasDiscordWebhook())->toBeTrue();

    $groupWithout = Group::factory()->create([
        'discord_webhook_url' => null,
    ]);

    expect($groupWithout->hasDiscordWebhook())->toBeFalse();
});
