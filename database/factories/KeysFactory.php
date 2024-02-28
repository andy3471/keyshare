<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Dlc;
use App\Models\Game;
use App\Models\Key;
use App\Models\Platform;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Key::class, function (Faker $faker) {

    return [
        'key_type_id' => function (array $key) {
            if (config('app.dlc_enabled')) {
                return rand(1, 2);
            } else {
                return 1;
            }
        },
        'game_id' => Game::all()->random()->id,
        'dlc_id' => function (array $key) {
            if ($key['key_type_id'] == 2) {
                $game_id = $key['game_id'];

                $dlc = Dlc::inRandomOrder()->where('Game_id', $game_id)->first();

                if ($dlc == null) {
                    $dlc = factory(\App\Models\Dlc::class)->create([
                        'game_id' => $game_id,
                    ]);
                }

                return $dlc->id;
            } else {
                return null;
            }
        },
        'platform_id' => Platform::all()->random()->id,
        'keycode' => $faker->uuid,
        'owned_user_id' => function () {
            if (rand(0, 1) == 1) {
                return User::all()->random()->id;
            } else {
                return null;
            }
        },
        'created_user_id' => User::all()->random()->id,
        'message' => $faker->paragraph($nbSentences = 1),
    ];
});
