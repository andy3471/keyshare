<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Key;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KeysTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** A basic test example. */
    public function test_user_can_create_key(): void
    {
        $user     = User::factory()->create();
        $gamename = $this->faker->realText(20);

        $attributes = [
            'gamename'    => $gamename,
            'platform_id' => 1,
            'key'         => $this->faker->uuid,
            'message'     => $this->faker->uuid,
        ];

        $this->actingAs($user)->post('/addkey/store', $attributes);

        $this->assertDatabaseHas('games', ['name' => $gamename]);

        // Need to assert redirect.
    }

    public function test_user_can_view_key(): void
    {
        $user = User::factory()->create();
        Game::factory()->create();
        $key = Key::factory()->create();

        $this->actingAs($user)->get('/keys/'.$key->id)
            ->assertStatus(200);
    }
}
