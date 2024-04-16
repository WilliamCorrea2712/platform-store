<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;

class ApiTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = env('API_TOKEN');

        $request->headers->set('Authorization', 'Bearer ' . $token);

        return $next($request);
    }
}
?>