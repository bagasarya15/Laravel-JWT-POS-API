<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class VerifyToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('/') || $request->is('api/auth/login')) {
            return $next($request);
        }

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => 401,
                'message' => 'Token not provided'
            ], 401);
        }

        try {
            $payload = JWTAuth::setToken($token)->getPayload();
            $userId = $payload['sub'];

            $hasToken = DB::table('token_access')
                ->where('user_id', $userId)
                ->where('token', $token)
                ->exists();

            if (!$hasToken) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthenticated'
                ], 401);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 401,
                'message' => 'Authorization error: ' . $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
