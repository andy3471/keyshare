<?php

namespace App\Http\Middleware;

use Closure;

class DemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.demo_mode') == true) {
            return redirect('demo');
        }

        return $next($request);
    }
}
