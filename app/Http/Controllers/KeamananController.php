<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;   // Model Log Aktivitas
use App\Models\PenilaianDetail; // Model Riwayat Penilaian

class KeamananController extends Controller
{
    /**
     * 11.1 Lihat Riwayat Penilaian
     * Menampilkan log penilaian kinerja antar karyawan/manajer
     */
    public function riwayatPenilaian()
    {
        // Ambil data detail penilaian beserta relasinya (Penilai, Karyawan Dinilai, Indikator, Periode)
        $riwayat = PenilaianDetail::with([
                'header.penilai',       // User Penilai
                'header.karyawan',      // Karyawan yang Dinilai
                'indikator',            // Indikator KPI
                'header.periode'        // Periode Evaluasi
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.keamanan.riwayat_penilaian', compact('riwayat'));
    }

    /**
     * 11.2 Lihat Aktivitas User
     * Menampilkan log login dan aktivitas sistem
     */
    public function aktivitasUser()
    {
        // Ambil data Log Aktivitas
        $logs = LogAktivitas::with('user') 
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.keamanan.aktivitas_user', compact('logs'));
    }
}