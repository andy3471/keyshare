<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Dlc;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DlcFactory extends Factory
{
    protected $model = Dlc::class;

    public function definition(): array
    {
        return [
            'game_id'         => Game::all()->random()->id,
            'name'            => fake()->unique()->realText(20),
            'description'     => fake()->paragraph($nbSentences = 1),
            'created_user_id' => User::all()->random()->id,
        ];
    }
}
