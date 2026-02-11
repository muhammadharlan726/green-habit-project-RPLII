<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Tambahan untuk akses data user

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // CEK: Apakah user sudah Login DAN apakah dia Admin?
        // Auth::check() : Mengecek apakah ada user yang login
        // Auth::user()?->is_admin : Mengecek kolom is_admin di database bernilai 1 (True)
        if (Auth::check() && Auth::user()?->is_admin) {
            return $next($request); // Silakan masuk, Bos!
        }

        // Kalau bukan admin (atau belum login), tendang balik ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', '⛔ Area Terlarang! Kamu bukan Admin.');
    }
}