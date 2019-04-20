<?php

use Illuminate\Database\Seeder;
use App\Keys;
use App\Games;
use App\Platforms;
use App\User;

class KeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 500) as $index) {
            $game = Games::orderByRaw("RAND()")->first();
            $platform = Platforms::orderByRaw("RAND()")->first();
            $createduser = User::orderByRaw("RAND()")->first();
            $owneduser = User::orderByRaw("RAND()")->first();

            if (rand (0,1) == 1) {
                $owneduser->id = null;
            }

            if (rand (0,1) == 1) {
                $message = $faker->paragraph($nbSentences = 1);
            } else {
                $message = null;
            }

            Keys::create([
                'game_id'           =>  $game->id,
                'platform_id'       =>  $platform->id,
                'keycode'           =>  $faker->uuid,
                'owned_user_id'     =>  $owneduser->id,
                'created_user_id'   =>  $createduser->id,
                'message'           =>  $message,
            ]);

            Artisan::call('karma:calculate');
        }
    }
}
