<?php

namespace App\Http\Middleware;

use Closure;
Use Session;
class AdminMiddleware
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
        if(Session::has('name'))
        {
            return $next($request);
        }
        else
            return redirect("signin");
    }
}
