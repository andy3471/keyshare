<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class SteamLoginEnabled
{
    public function handle($request, Closure $next)
    {
        if (config('keyshare.steamlogin')) {
            return $next($request);
        }

        return redirect('index');
    }
}
