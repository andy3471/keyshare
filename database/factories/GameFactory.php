<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->realText(20),
            'description' => fake()->paragraph($nbSentences = 1),
            'created_user_id' => User::all()->random()->id,
        ];
    }
}
