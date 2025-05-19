<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class DemoMode
{
    public function handle($request, Closure $next)
    {
        if (config('app.demo_mode')) {
            return redirect('demo');
        }

        return $next($request);
    }
}
