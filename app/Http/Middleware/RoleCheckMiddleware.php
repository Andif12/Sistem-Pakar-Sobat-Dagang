<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $guard
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Memeriksa apakah pengguna sudah login dengan guard 'disdag'
        if (!Auth::guard('disdag')->check()) {
            Log::info('User not logged in with disdag guard');
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        // Mendapatkan pengguna yang login
        $user = Auth::guard('disdag')->user();
        Log::info('User role: ' . $user->role . ', Required role: ' . $role);

        // Memeriksa apakah role pengguna sesuai dengan yang dibutuhkan
        if ($user->role != $role) {
            Log::info('Role mismatch. User role: ' . $user->role . ', Required role: ' . $role);
            return redirect()->route('login')->withErrors(['auth' => 'Anda Tidak Memiliki Akses ke Halaman .']);
        }

        Log::info('Role check passed for user: ' . $user->role);
        return $next($request);
    }

}