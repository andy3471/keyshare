<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoModeRefresh extends Command
{
    protected $signature = 'demo:refresh';

    protected $description = 'Refresh Database if the site is in demo mode';

    public function handle(): mixed
    {
        if (! config('app.demo_mode')) {
            return null;
        }

        $this->call('migrate:fresh', ['--seed' => true]);
    }
}
