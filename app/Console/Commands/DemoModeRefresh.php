<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoModeRefresh extends Command
{
    protected $signature = 'demo:refresh';

    protected $description = 'Refresh Database if the site is in demo mode';

    public function handle(): mixed
    {
        if (config('app.demo_mode')) {
            $this->call('migrate:fresh', ['--seed' => true]);
        }
    }
}
