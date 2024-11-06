<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Model::preventLazyLoading(app()->isLocal());

        View::composer(
            'layouts.app',
            'App\Http\ViewComposers\PlatformViewComposer'
        );
    }
}
