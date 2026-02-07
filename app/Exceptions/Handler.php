<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    public function register(): void
    {
        if (class_exists(\Sentry\Laravel\Integration::class)) {
            $this->reportable(function (Throwable $e): void {
                \Sentry\Laravel\Integration::captureUnhandledException($e);
            });
        }
    }

    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
