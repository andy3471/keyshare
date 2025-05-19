<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Console\Command;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class UpdateGames extends Command
{
    protected $signature = 'igdb:update';

    protected $description = 'Pulls info from IGDB om each game';

    public function handle(): void
    {
        // TODO: Tidy this
        if (config('igdb.enabled')) {
            $daysToSubtract = config('igdb.update_freq');
            $beforeDate     = Carbon::now()->subDay();
            $this->info("Looking for games last updated before {$beforeDate}");

            $games = Game::where('igdb_updated', '<', $beforeDate)->whereNotNull('igdb_id')->get();

            foreach ($games as $game) {
                $this->info("Updating {$game->name}");
                $igdb               = Igdb::select(['name', 'summary', 'id'])->with(['cover' => ['image_id']])->where('id', '=', $game->id)->first();
                $game->name         = $igdb->name;
                $game->description  = $igdb->summary;
                $game->igdb_id      = $igdb->id;
                $game->image        = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
                $game->igdb_updated = Carbon::today();
                $game->save();
            }

            $this->info('Done');
        } else {
            $this->info('IGDB API Not Enabled');
        }
    }
}
