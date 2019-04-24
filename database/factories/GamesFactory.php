<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Games;
use Faker\Generator as Faker;
use App\User;

$factory->define(Games::class, function (Faker $faker) {
    return [
        'name'              =>  $faker->realText(20),
        'description'       =>  $faker->paragraph($nbSentences = 1),
        'created_user_id'   =>  User::all()->random()->id,
    ];
});
