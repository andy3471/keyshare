<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\TopUp;
use App\Platform;
use Faker\Generator as Faker;

$factory->define(TopUp::class, function (Faker $faker) {
    return [
        'platform_id'       =>  Platform::all()->random()->id,
        'name'              =>  $faker->unique()->realText(20),
        'description'       =>  $faker->paragraph($nbSentences = 1)
    ];
});
