<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class UpdateGames extends Command
{
    protected $signature = 'igdb:update';

    protected $description = 'Pulls info from IGDB om each game';

    public function handle(): void
    {
        // Games now fetch data from IGDB on-demand, so this command is no longer needed
        // Keeping it for backwards compatibility but it does nothing
        $this->info('Games now fetch data from IGDB on-demand. No update needed.');
    }
}
