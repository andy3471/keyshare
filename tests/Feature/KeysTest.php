<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Key;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KeysTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_create_key()
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

        // Need to assert redirect.
    }

    public function test_user_can_view_key()
    {
        $user = factory(User::class)->create();
        $game = factory(Game::class)->create();
        $key = factory(Key::class)->create();

        $this->actingAs($user)->get('/keys/'.$key->id)
            ->assertStatus(200);
    }
}
