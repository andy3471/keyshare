<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Dlc;
use App\Game;
use Faker\Generator as Faker;

$factory->define(Dlc::class, function (Faker $faker) {
    return [
        'game_id'           =>  Game::all()->random()->id,
        'name'              =>  $faker->unique()->realText(20),
        'description'       =>  $faker->paragraph($nbSentences = 1)
    ];
});
