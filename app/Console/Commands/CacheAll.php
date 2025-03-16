<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CacheAll extends Command
{
    protected $signature = 'cache:all';

    protected $description = 'Command description';

    public function handle(): void
    {
        $this->info('Caching Icons...');
        Artisan::call('icons:cache');

        $this->info('Caching Events...');
        Artisan::call('event:cache');

        $this->info('Caching Routes...');
        Artisan::call('route:cache');

        $this->info('Caching Filament Components...');
        Artisan::call('filament:cache-components');

        $this->info('Caching Config...');
        Artisan::call('config:cache');

        $this->info('Caching Views...');
        Artisan::call('view:cache');

        $this->info('Caching Karma...');
        Artisan::call('cache:karma');
    }
}
