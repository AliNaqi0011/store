<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    public function handle(Request $request, Closure $next, string $key = 'api', int $maxAttempts = 60): Response
    {
        $identifier = $request->ip();
        
        if (RateLimiter::tooManyAttempts($key . ':' . $identifier, $maxAttempts)) {
            return response()->json([
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => RateLimiter::availableIn($key . ':' . $identifier)
            ], 429);
        }

        RateLimiter::hit($key . ':' . $identifier, 60);

        return $next($request);
    }
}