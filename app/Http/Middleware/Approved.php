<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class Approved
{
    public function handle($request, Closure $next)
    {
        if (! auth()->user()->approved) {
            return redirect('notapproved');
        }

        return $next($request);
    }
}
