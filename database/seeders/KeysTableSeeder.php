<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Key;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class KeysTableSeeder extends Seeder
{
    public function run(): void
    {
        if (Game::count() === 0) {
            $this->command->warn('Skipping key seeding: No games found. Games must be created via IGDB API first.');

            return;
        }

        Key::factory(500)->create();
        Artisan::call('karma:calculate');
    }
}
