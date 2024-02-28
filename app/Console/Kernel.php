<?php

namespace App\Console;

use App\Console\Commands\DemoModeRefresh;
use App\Console\Commands\UpdateGames;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CalculateKarma::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(DemoModeRefresh::class)
            ->daily();

        $schedule->command(UpdateGames::class)
            ->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
