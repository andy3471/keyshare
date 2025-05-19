<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo('/home');

        $middleware->encryptCookies(except: [
            'XDEBUG_SESSION',
        ]);

        $middleware->append(\App\Http\Middleware\CheckForMaintenanceMode::class);

        $middleware->throttleApi('60,1');

        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'approved' => \App\Http\Middleware\Approved::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'demomode' => \App\Http\Middleware\DemoMode::class,
            'steamlogin' => \App\Http\Middleware\SteamLoginEnabled::class,
        ]);

        $middleware->priority([
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Authenticate::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Auth\Middleware\Authorize::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
