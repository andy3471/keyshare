<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Keys;
use Faker\Generator as Faker;
use App\User;
use App\Games;
use App\Platforms;

$factory->define(Keys::class, function (Faker $faker) {
    return [
        'game_id'           =>  Games::all()->random()->id,
        'platform_id'       =>  Platforms::all()->random()->id,
        'keycode'           =>  $faker->uuid,
        'owned_user_id'     =>  function() {
                                    if (rand(0, 1) == 1) {
                                        return User::all()->random()->id;
                                    } else {
                                        return null;
                                    }
                                },
        'created_user_id'   =>  User::all()->random()->id,
        'message'           =>  $faker->paragraph($nbSentences = 1),
    ];
});
