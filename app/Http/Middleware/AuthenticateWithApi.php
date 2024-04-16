<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateWithApi
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
        if (!session()->has('api_token')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
