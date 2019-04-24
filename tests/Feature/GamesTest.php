<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Games;

class GamesTest extends TestCase
{

    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testViewGamesPage()
    {
        $user   =   factory(User::class)->create();
        $game   =   factory(Games::class)->create();

        $this->actingAs($user)->get('/games/' . $game->id)
            ->assertStatus(200)
            ->assertSee($game->name);
    }
}
