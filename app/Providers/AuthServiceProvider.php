<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('approved', function ($user) {
            return $user->is_approved;
        });

        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}
