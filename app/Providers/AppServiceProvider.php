<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    public function boot()
    {
        Model::preventLazyLoading(app()->isLocal());

        View::composer(
            'layouts.app',
            'App\Http\ViewComposers\PlatformViewComposer'
        );

        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        $this->bootAuth();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function bootAuth()
    {

        Gate::define('approved', function ($user) {
            return $user->approved;
        });

        Gate::define('admin', function ($user) {
            return $user->admin;
        });
    }
}
