<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Platform;
use App\Models\User;
use App\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'platform_id' => Platform::all()->random()->id,
        'value' => function () {
            return rand(1, 100);
        },
        'description' => $faker->paragraph($nbSentences = 1),
        'created_user_id' => User::all()->random()->id,
    ];
});
