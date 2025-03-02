<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Key>
 */
class KeyFactory extends Factory
{
    protected $model = Key::class;

    public function definition(): array
    {
        return [
            'game_id' => Game::all()->random()->id,
            'platform_id' => Platform::all()->random()->id,
            'keycode' => fake()->uuid,
            'owned_user_id' => function () {
                if (rand(0, 1) == 1) {
                    return User::all()->random()->id;
                } else {
                    return null;
                }
            },
            'created_user_id' => User::all()->random()->id,
            'message' => fake()->paragraph($nbSentences = 1),
        ];
    }
}
