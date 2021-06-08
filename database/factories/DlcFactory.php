<?php

namespace Database\Factories;

use App\Models\Dlc;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DlcFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dlc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_id'           =>  Game::all()->random()->id,
            'name'              =>  $this->faker->unique()->realText(20),
            'description'       =>  $this->faker->paragraph($nbSentences = 1),
            'created_user_id'   =>  User::all()->random()->id,
        ];
    }
}
