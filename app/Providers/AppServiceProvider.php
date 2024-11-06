<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        View::composer(
            'layouts.app',
            'App\Http\ViewComposers\PlatformViewComposer'
        );
    }
}
