<?php

namespace App\Providers;

use App\Models\Platform;
use Cache;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // TODO move to intertia middleware
        Inertia::share('platforms', function () {
            return Cache::remember('platforms', 3600, function () {
                return Platform::all();
            });
        });

        Inertia::share('config.name', config('app.name'));
        Inertia::share('config.dlc_enabled', config('app.dlc_enabled'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
