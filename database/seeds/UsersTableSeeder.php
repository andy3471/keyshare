<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 20) as $index) {

            if (rand (0,1) == 1) {
                $bio = null;
            } else {
                $bio = $faker->paragraph($nbSentences = 1);
            }

            User::create([
                'name'      =>  $faker->username,
                'email'     =>  $faker->email,
                'password'  =>  Hash::make('password'),
                'bio'       =>  $bio
            ]);
        }
    }
}
