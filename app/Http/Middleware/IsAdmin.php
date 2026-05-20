<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan apakah rolenya adalah admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Izinkan lanjut akses route
        }

        // Jika bukan admin, tendang kembali ke beranda dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses Admin.');
    }
}