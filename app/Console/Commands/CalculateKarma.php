<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\KarmaService;
use Illuminate\Console\Command;

class CalculateKarma extends Command
{
    protected $signature = 'karma:calculate';

    protected $description = 'Recalculate karma for all users';

    public function handle(KarmaService $karmaService): void
    {
        $karmaService->recalculateAll();

        $this->info('Karma recalculated for all users.');
    }
}
