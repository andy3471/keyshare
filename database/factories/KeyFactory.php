<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyFactory extends Factory
{
    protected $model = Key::class;

    public function definition(): array
    {
        return [
            'game_id' => function () {
                $games = Game::all();
                if ($games->isEmpty()) {
                    throw new Exception('No games available. Games must be created via IGDB API first.');
                }

                return $games->random()->id;
            },
            'platform_id' => function () {
                return Platform::all()->random()->id;
            },
            'key'             => fake()->uuid,
            'owned_user_id'   => null,
            'created_user_id' => User::factory(),
            'group_id'        => null,
            'message'         => fake()->paragraph($nbSentences = 1),
        ];
    }
}
