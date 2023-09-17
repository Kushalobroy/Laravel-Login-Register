<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        if ($token) {
            $user = Auth::guard('api')->user();
            if ($user) {
                return $next($request);
            }
        }
        $apiKey = $request->header('API-KEY');
        if ($apiKey === 'helloatg') {
            return $next($request);
        }
        return response()->json(['status' => 0, 'message' => 'Invalid API key'], 401);
    }
}
