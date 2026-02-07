<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GamesTableSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $igdbGames = Igdb::select(['name', 'summary', 'id', 'aggregated_rating'])
            ->with(['cover' => ['image_id'], 'parent_game'])
            ->where('aggregated_rating', '!=', null)
            ->whereNull('parent_game')
            ->orderBy('aggregated_rating', 'desc')
            ->limit(50)
            ->get();

        if ($igdbGames->isEmpty()) {
            $igdbGames = Igdb::select(['name', 'summary', 'id'])
                ->with(['cover' => ['image_id'], 'parent_game'])
                ->whereNull('parent_game')
                ->limit(50)
                ->get();
        }

        $count = 0;
        foreach ($igdbGames as $igdbGame) {
            if (Game::where('igdb_id', $igdbGame->id)->exists()) {
                continue;
            }

            Game::createFromIgdb($igdbGame);
            $count++;
        }

        $this->command->info("Seeded {$count} games from IGDB.");
    }
}
