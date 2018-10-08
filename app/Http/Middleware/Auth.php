<?php

namespace App\Http\Middleware;

use JWT;
use Closure;

class Auth
{
    public function handle($request, Closure $next)
    {
        if (JWT::parseToken() === false) {
            return error_response('token is invalid', 403);
        }

        return $next($request);
    }
}
