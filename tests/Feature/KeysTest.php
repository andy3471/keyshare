<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Game;
use App\Key;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KeysTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanCreateKey()
    {
        $user = factory(User::class)->create();
        $gamename = $this->faker->realText(20);

        $attributes = [
            'gamename' => $gamename,
            'platform_id' => 1,
            'key' => $this->faker->uuid,
            'message' => $this->faker->uuid,
        ];

        $this->actingAs($user)->post('/addkey/store', $attributes);

        $this->assertDatabaseHas('games', ['name' => $gamename]);

        //Need to assert redirect.
    }

    public function testUserCanViewKey()
    {
        $user   =   factory(User::class)->create();
        $game   =   factory(Game::class)->create();
        $key    =   factory(Key::class)->create();

        $this->actingAs($user)->get('/keys/' . $key->id)
            ->assertStatus(200);
    }
}
