<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        $this->configureModels();
        $this->configureCarbon();
        $this->configureDatabase();
        $this->configureVite();
        $this->bootAuth();

        $this->bootAuth();
    }

    public function bootAuth(): void
    {

        Gate::define('approved', function ($user) {
            return $user->is_approved;
        });

        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }

    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    private function configureDatabase(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    private function configureCarbon(): void
    {
        Date::use(CarbonImmutable::class);
        CarbonInterval::enableFloatSetters();
    }

    private function configureModels(): void
    {
        Model::automaticallyEagerLoadRelationships();
        Model::preventLazyLoading(app()->isLocal());
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function bootAuth(): void
    {

        Gate::define('approved', function ($user) {
            return $user->is_approved;
        });

        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}
