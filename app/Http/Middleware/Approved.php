<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Approved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::user()->approved == 0) {
            return redirect('notapproved');
        }

        return $next($request);
    }
}
