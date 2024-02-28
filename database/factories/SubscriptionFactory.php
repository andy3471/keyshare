<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Platform;
use App\Models\Subscription;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'platform_id' => Platform::all()->random()->id,
        'name' => $faker->unique()->realText(10),
        'description' => $faker->paragraph($nbSentences = 1),
        'created_user_id' => User::all()->random()->id,
    ];
});
