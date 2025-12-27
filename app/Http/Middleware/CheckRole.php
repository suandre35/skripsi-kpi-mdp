<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Ambil role user saat ini
        $userRole = Auth::user()->role; // 'HRD', 'Manajer', atau 'Karyawan'

        // 3. Cek apakah role user ada di dalam daftar role yang diizinkan
        // Contoh pemanggilan di route: middleware('role:HRD,Manajer')
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika tidak cocok, tolak akses (403 Forbidden)
        abort(403, 'Akses Ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
