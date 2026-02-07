<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Group;
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

        $groups = Group::all();

        if ($groups->isEmpty()) {
            $this->command->warn('Skipping key seeding: No groups found. Run GroupsTableSeeder first.');

            return;
        }

        Key::factory(500)->create([
            'group_id'        => fn () => $groups->random()->id,
            'created_user_id' => function () use ($groups) {
                $group = $groups->random();

                return $group->members()->inRandomOrder()->first()->id;
            },
        ]);

        Artisan::call('karma:calculate');

        $this->command->info('Seeded 500 keys across '.$groups->count().' groups.');
    }
}
