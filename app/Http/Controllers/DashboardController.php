<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\PeriodeEvaluasi;
use App\Models\Divisi;
use App\Models\PenilaianHeader;
use App\Models\PenilaianDetail; // Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'HRD') {
            return $this->dashboardHRD();
        } elseif ($user->role === 'Manajer') {
            return $this->dashboardManajer();
        } else {
            return $this->dashboardKaryawan();
        }
    }

    // --- LOGIKA DASHBOARD HRD (REVISI FINAL) ---
    private function dashboardHRD()
    {
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();
        
        // 1. Total Karyawan (Role Karyawan & Aktif)
        $totalKaryawan = User::where('role', 'Karyawan')->where('status', true)->count();
        
        // 2. Total Divisi
        $totalDivisi = Divisi::where('status', true)->count();
        
        $totalPenilaian = 0;
        $latestPenilaian = [];

        if ($periodeAktif) {
            // 3. Hitung Total DETAIL Penilaian (Item indikator yg sudah dinilai)
            // Menggunakan whereHas ke header untuk filter periode aktif
            $totalPenilaian = PenilaianDetail::whereHas('header', function($q) use ($periodeAktif) {
                $q->where('id_periode', $periodeAktif->id_periode);
            })->count();

            // 4. Feed Penilaian Terbaru dengan PAGINATION (Limit 5)
            $latestPenilaian = PenilaianHeader::with(['karyawan.divisi', 'penilai'])
                ->where('id_periode', $periodeAktif->id_periode)
                ->orderBy('created_at', 'desc')
                ->paginate(5); // Menggunakan paginate, bukan get()
        }

        return view('dashboard', compact('periodeAktif', 'totalKaryawan', 'totalDivisi', 'totalPenilaian', 'latestPenilaian'));
    }

    // --- MANAJER (TETAP) ---
    private function dashboardManajer() 
    { 
        $user = Auth::user();
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();
        $myDivisi = Divisi::where('id_manajer', $user->id_user)->first();

        $stats = ['total_staff' => 0, 'sudah_dinilai' => 0, 'belum_dinilai' => 0, 'progress' => 0];
        $staffList = []; 

        if ($myDivisi) {
            $staffs = Karyawan::where('id_divisi', $myDivisi->id_divisi)
                              ->where('id_user', '!=', $user->id_user)
                              ->where('status', true)
                              ->get();

            $stats['total_staff'] = $staffs->count();

            if ($periodeAktif) {
                foreach ($staffs as $staff) {
                    $penilaian = PenilaianHeader::where('id_periode', $periodeAktif->id_periode)
                                                ->where('id_karyawan', $staff->id_karyawan)
                                                ->first();
                    $isDone = $penilaian ? true : false;
                    
                    if ($isDone) $stats['sudah_dinilai']++;
                    else $stats['belum_dinilai']++;

                    $staffList[] = (object) [
                        'id_karyawan' => $staff->id_karyawan,
                        'nama' => $staff->nama_lengkap,
                        'nik' => $staff->nik,
                        'foto' => $staff->foto,
                        'status_penilaian' => $isDone ? 'Sudah' : 'Belum',
                        'tanggal_dinilai' => $isDone ? $penilaian->created_at : null,
                        'id_penilaian' => $isDone ? $penilaian->id_penilaianHeader : null 
                    ];
                }
                if ($stats['total_staff'] > 0) {
                    $stats['progress'] = round(($stats['sudah_dinilai'] / $stats['total_staff']) * 100);
                }
            }
        }
        return view('dashboard', compact('periodeAktif', 'stats', 'myDivisi', 'staffList')); 
    }

    // --- KARYAWAN (TETAP) ---
    private function dashboardKaryawan() 
    { 
        $user = Auth::user();
        $karyawan = Karyawan::with('divisi')->where('id_user', $user->id_user)->first();
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();

        $stats = ['status_periode_ini' => 'Menunggu', 'tanggal_dinilai' => null, 'penilai' => '-', 'total_history' => 0];

        if ($karyawan && $periodeAktif) {
            $penilaianSaatIni = PenilaianHeader::with('penilai')
                ->where('id_periode', $periodeAktif->id_periode)
                ->where('id_karyawan', $karyawan->id_karyawan)
                ->first();

            if ($penilaianSaatIni) {
                $stats['status_periode_ini'] = 'Selesai';
                $stats['tanggal_dinilai'] = $penilaianSaatIni->created_at;
                $stats['penilai'] = $penilaianSaatIni->penilai->name ?? 'Manajer';
            }
        }

        $riwayatPenilaian = [];
        if ($karyawan) {
            $riwayatPenilaian = PenilaianHeader::with(['periode', 'penilai'])
                ->where('id_karyawan', $karyawan->id_karyawan)
                ->orderBy('created_at', 'desc')
                ->get();
            $stats['total_history'] = $riwayatPenilaian->count();
        }
        return view('dashboard', compact('periodeAktif', 'karyawan', 'stats', 'riwayatPenilaian')); 
    }
}