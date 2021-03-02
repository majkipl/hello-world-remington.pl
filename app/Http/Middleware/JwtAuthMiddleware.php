<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();

            return $next($request);
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expiried'], Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token invalid'], Response::HTTP_UNAUTHORIZED);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token exception'], Response::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json(['message' => 'Token exception 1'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
