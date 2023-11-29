<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class EmailVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Add logging or debugging statements here
    
        // dd(Session::get('user_email'));
        if (!Session::has('user_phone') && !Session::has('user_email')) {
            // dd(8923764928);
            return redirect()->route('register');
        }
        return $next($request);
    
        
    }
}
