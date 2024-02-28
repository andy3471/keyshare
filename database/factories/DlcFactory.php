<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Dlc;
use App\Models\Game;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Dlc::class, function (Faker $faker) {
    return [
        'game_id' => Game::all()->random()->id,
        'name' => $faker->unique()->realText(20),
        'description' => $faker->paragraph($nbSentences = 1),
        'created_user_id' => User::all()->random()->id,
    ];
});
