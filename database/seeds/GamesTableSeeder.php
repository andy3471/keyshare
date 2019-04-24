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
        factory(App\Games::class, 100)->create();
    }
}
