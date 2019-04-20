<?php

use Illuminate\Database\Seeder;
Use App\Games;
Use App\User;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 100) as $index) {
            $user = User::orderByRaw("RAND()")->first();

            Games::create([
                'name'      =>  $faker->realText(20),
                'description'     =>  $faker->paragraph($nbSentences = 1),
                'created_user_id'     =>  $user->id
            ]);
        }
    }
}
