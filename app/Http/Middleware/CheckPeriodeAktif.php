<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PeriodeEvaluasi;
use Carbon\Carbon;

class CheckPeriodeAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ambil Periode yang statusnya true (Aktif)
        // PERUBAHAN: where('status', true)
        $periode = PeriodeEvaluasi::where('status', true)->first();

        // 2. Cek apakah ada periode aktif?
        if (!$periode) {
            return redirect()->route('dashboard')->with('error', 'Akses ditutup. Tidak ada periode evaluasi yang aktif saat ini.');
        }

        // 3. Cek Rentang Waktu
        $sekarang = Carbon::now();

        if ($sekarang->lt($periode->tanggal_mulai)) {
            return redirect()->route('dashboard')->with('error', 'Periode evaluasi belum dimulai. Silakan tunggu hingga ' . $periode->tanggal_mulai->format('d M Y H:i'));
        }

        if ($sekarang->gt($periode->tanggal_selesai)) {
            return redirect()->route('dashboard')->with('error', 'Periode evaluasi sudah berakhir pada ' . $periode->tanggal_selesai->format('d M Y H:i'));
        }

        return $next($request);
    }
}