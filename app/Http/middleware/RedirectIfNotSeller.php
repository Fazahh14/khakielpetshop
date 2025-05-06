<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotSeller
{
    public function handle($request, Closure $next)
    {
        return Auth::check() && Auth::user()->role === 'seller'
            ? $next($request)
            : redirect('/login');
    }
}
