<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        if (env('REDIRECT_HTTPS')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer(
            'layouts.app',
            'App\Http\ViewComposers\PlatformViewComposer'
        );
    }
}
