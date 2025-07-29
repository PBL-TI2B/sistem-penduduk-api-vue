<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            // Pengguna belum login, arahkan ke halaman login atau berikan respons unauthorized
            return redirect('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        // Periksa apakah pengguna memiliki salah satu role yang diizinkan
        if (!$user->hasAnyRole($roles)) {
            // Pengguna tidak memiliki role yang diizinkan, arahkan kembali atau berikan respons unauthorized
            abort(403, 'Unauthorized: Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}