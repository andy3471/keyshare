<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\User;

it('lets an authenticated user view a game page', function (): void {
    $game = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);

    $this->actingAs(User::factory()->create())
        ->get("/games/{$game->igdb_id}")
        ->assertOk();
});

it('redirects guests from game pages', function (): void {
    $game = Game::create(['igdb_id' => fake()->unique()->randomNumber(5)]);

    $this->get("/games/{$game->igdb_id}")
        ->assertRedirect('/login');
});
