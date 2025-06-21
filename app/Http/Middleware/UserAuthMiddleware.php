<?php

// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthMiddleware
{
    // app/Http/Middleware/EnsureUserIsAuthenticated.php
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Silakan login sebagai ' . $guard,
            ]);
        }

        return $next($request);
    }
}