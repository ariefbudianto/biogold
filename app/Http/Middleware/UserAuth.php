<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Sentinel;

class UserAuth
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
        if (($user = Sentinel::check()))
        {
            return $next($request);
        } else {
            return redirect()->route('user.login');
        }
    }
}
