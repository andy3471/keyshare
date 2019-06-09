<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(TopUpTableSeeder::class);
        $this->call(DlcTableSeeder::class);
        $this->call(KeysTableSeeder::class);
    }
}
