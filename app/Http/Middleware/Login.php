<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class Login
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('token') == null) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
