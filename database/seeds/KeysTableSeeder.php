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
        factory(App\Keys::class, 500)->create();
        Artisan::call('karma:calculate');
    }
}
