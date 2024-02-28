<?php

use Illuminate\Database\Seeder;

class KeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Key::class, 500)->create();
        Artisan::call('karma:calculate');
    }
}
