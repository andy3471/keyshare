<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Key;
use App\Models\User;
use App\Observers\KeyKarmaObserver;
use App\Observers\KeyNotificationObserver;
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
    public const HOME = '/games';

    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        $this->configureModels();
        $this->configureCarbon();
        $this->configureDatabase();
        $this->configureVite();
        $this->configureObservers();
        $this->configureGates();
    }

    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    private function configureDatabase(): void
    {
        DB::prohibitDestructiveCommands(
            app()->isProduction()
        );
    }

    private function configureCarbon(): void
    {
        Date::use(CarbonImmutable::class);
        CarbonInterval::enableFloatSetters();
    }

    private function configureObservers(): void
    {
        Key::observe(KeyKarmaObserver::class);
        Key::observe(KeyNotificationObserver::class);
    }

    private function configureGates(): void
    {
        Gate::before(fn (User $user): ?bool => $user->is_admin ? true : null);
    }

    private function configureModels(): void
    {
        Model::automaticallyEagerLoadRelationships();
        Model::preventLazyLoading(app()->isLocal());
    }
}
