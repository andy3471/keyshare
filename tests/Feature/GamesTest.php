<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GamesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_view_games_page()
    {
        $user = factory(User::class)->create();
        $game = factory(Game::class)->create();

        $this->actingAs($user)->get('/games/'.$game->id)
            ->assertStatus(200)
            ->assertSee($game->name);
    }
}
