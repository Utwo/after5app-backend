<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Middleware\GetUserFromToken;

class JwtOptional extends GetUserFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
