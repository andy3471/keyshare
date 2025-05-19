<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->admin) {
            return $next($request);
        }

        return redirect('index');
    }
}
