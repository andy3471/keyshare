<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(DlcTableSeeder::class);
        $this->call(SubscriptionTableSeeder::class);
        $this->call(KeysTableSeeder::class);
    }
}
