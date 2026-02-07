<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Dlc;
use App\Models\Game;
use App\Models\Key;
use App\Models\KeyType;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyFactory extends Factory
{
    protected $model = Key::class;

    public function definition(): array
    {
        return [
            'key_type_id' => function (array $key) {
                if (config('app.dlc_enabled')) {
                    return rand(1, 2);
                }
                
                return 1;
            },
            'game_id' => Game::all()->random()->id,
            'dlc_id'  => function (array $key) {
                // Check if key_type_id matches DLC (ID = 2)
                if ($key['key_type_id'] === KeyType::DLC) {
                    $game_id = $key['game_id'];

                    $dlc = Dlc::inRandomOrder()->where('game_id', $game_id)->first();

                    if ($dlc === null) {
                        $dlc = Dlc::factory()->create([
                            'game_id' => $game_id,
                        ]);
                    }

                    return $dlc->id;
                }

                return null;

            },
            'platform_id'   => function () {
                return Platform::all()->random()->id;
            },
            'keycode'       => fake()->uuid,
            'owned_user_id' => function () {
                if (rand(0, 1) === 1) {
                    return User::all()->random()->id;
                }

                return null;

            },
            'created_user_id' => User::all()->random()->id,
            'message'         => fake()->paragraph($nbSentences = 1),
        ];
    }
}
