<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\CalculateKarma;
use App\Console\Commands\DemoModeRefresh;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CalculateKarma::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(DemoModeRefresh::class)
            ->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
