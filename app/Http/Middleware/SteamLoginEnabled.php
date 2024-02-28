<?php

namespace App\Http\Middleware;

use Closure;

class SteamLoginEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('keyshare.steamlogin')) {
            return $next($request);
        } else {
            return redirect('home');
        }
    }
}
