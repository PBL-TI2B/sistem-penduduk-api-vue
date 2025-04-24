<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Cookie;

class EnsureTokenAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd($request->cookies->all());
        dd($request->headers->all());
        dd($request->all());


        // if (!$token) {
        //     return redirect('/login')->with('error', 'Token tidak ditemukan.');
        // }

        return $next($request);
    }
}
