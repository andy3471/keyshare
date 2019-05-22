<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Approved
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

        if ( Auth::user()->approved == 0 ) {
            return redirect('notapproved');
        };

        return $next($request);
    }
}
