<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Game;
use Exception;
use Illuminate\Database\Seeder;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // IGDB is required for game seeding
        if (! config('igdb.enabled')) {
            $this->command->warn('Skipping game seeding: IGDB API is not enabled. Please configure TWITCH_CLIENT_ID and TWITCH_CLIENT_SECRET.');

            return;
        }

        try {
            // Fetch popular games from IGDB (ordered by rating/popularity)
            // Limit to 50 games for seeding
            // Exclude DLCs (games with parent_game) - we only want base games for seeding
            $igdbGames = Igdb::select(['name', 'summary', 'id', 'aggregated_rating'])
                ->with(['cover' => ['image_id'], 'parent_game'])
                ->where('aggregated_rating', '!=', null)
                ->whereNull('parent_game')
                ->orderBy('aggregated_rating', 'desc')
                ->limit(50)
                ->get();

            if ($igdbGames->isEmpty()) {
                // Fallback: get any games if no rated games found (still exclude DLCs)
                $igdbGames = Igdb::select(['name', 'summary', 'id'])
                    ->with(['cover' => ['image_id'], 'parent_game'])
                    ->whereNull('parent_game')
                    ->limit(50)
                    ->get();
            }

            $count = 0;
            foreach ($igdbGames as $igdbGame) {
                // Skip if game already exists
                if (Game::where('igdb_id', $igdbGame->id)->exists()) {
                    continue;
                }

                Game::createFromIgdb($igdbGame);
                $count++;
            }

            $this->command->info("Seeded {$count} games from IGDB.");
        } catch (Exception $e) {
            $this->command->error('Failed to seed games from IGDB: '.$e->getMessage());
        }
    }
}
