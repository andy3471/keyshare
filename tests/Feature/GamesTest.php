<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GamesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** A basic feature test example. */
    public function test_view_games_page(): void
    {
        $user = User::factory()->create();
        $game = Game::factory()->create();

        $this->actingAs($user)->get('/games/'.$game->id)
            ->assertStatus(200)
            ->assertSee($game->name);
    }
}
