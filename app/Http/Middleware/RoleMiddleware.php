<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Tambahkan titik tiga (...) sebelum $roles agar bisa menerima banyak role sekaligus
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user ada di dalam daftar role yang diizinkan oleh rute
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk melihat halaman ini.');
        }

        return $next($request);
    }
}