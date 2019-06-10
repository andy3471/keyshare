<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Subscription;
use App\Platform;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'platform_id'       =>  Platform::all()->random()->id,
        'name'              =>  $faker->unique()->realText(10),
        'description'       =>  $faker->paragraph($nbSentences = 1)
    ];
});
