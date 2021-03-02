<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user || $user->role != UserRole::ADMIN) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
