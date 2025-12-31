<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Karyawan; // Pastikan import model Karyawan
use App\Models\PeriodeEvaluasi;
use App\Models\Divisi;
use App\Models\PenilaianHeader;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // CEK ROLE MANUAL (Sesuai kolom ENUM di database)
        if ($user->role === 'HRD') {
            return $this->dashboardHRD();
        } elseif ($user->role === 'Manajer') {
            return $this->dashboardManajer();
        } else {
            return $this->dashboardKaryawan();
        }
    }

    // --- LOGIKA DASHBOARD HRD ---
    private function dashboardHRD()
    {
        // 1. Ambil Periode Aktif
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();
        
        // Default values
        $stats = [
            'total_karyawan' => Karyawan::where('status', true)->count(), // Ambil dari tabel Karyawans
            'sudah_dinilai' => 0,
            'belum_dinilai' => 0,
            'persen_progress' => 0,
            'latest_assessments' => [] // Ganti Top Performers jadi Penilaian Terbaru (karena belum ada skor)
        ];
        
        $chartData = [
            'labels' => [],
            'data' => []
        ];

        if ($periodeAktif) {
            $totalKaryawan = $stats['total_karyawan'];
            
            // Hitung jumlah karyawan unik yang sudah dinilai di periode ini
            $sudahDinilai = PenilaianHeader::where('id_periode', $periodeAktif->id_periode)
                                           ->distinct('id_karyawan')
                                           ->count('id_karyawan');
            
            $stats['sudah_dinilai'] = $sudahDinilai;
            $stats['belum_dinilai'] = max(0, $totalKaryawan - $sudahDinilai);
            $stats['persen_progress'] = $totalKaryawan > 0 ? round(($sudahDinilai / $totalKaryawan) * 100) : 0;

            // Ambil 5 Penilaian Terakhir yang Masuk
            $stats['latest_assessments'] = PenilaianHeader::with(['karyawan.divisi', 'penilai'])
                ->where('id_periode', $periodeAktif->id_periode)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // GRAFIK: Partisipasi Per Divisi (Jumlah yg sudah dinilai per divisi)
            $divisis = Divisi::where('status', true)->get();
            foreach ($divisis as $div) {
                $count = PenilaianHeader::where('id_periode', $periodeAktif->id_periode)
                    ->whereHas('karyawan', function($q) use ($div) {
                        $q->where('id_divisi', $div->id_divisi);
                    })->count();

                $chartData['labels'][] = $div->nama_divisi;
                $chartData['data'][] = $count;
            }
        }

        return view('dashboard', compact('periodeAktif', 'stats', 'chartData'));
    }

    // --- Placeholder untuk Role Lain ---
    private function dashboardManajer() 
    { 
        $user = Auth::user();
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();

        // 1. Cari Divisi yang dipimpin Manajer ini
        $myDivisi = Divisi::where('id_manajer', $user->id_user)->first();

        $stats = [
            'total_staff' => 0,
            'sudah_dinilai' => 0,
            'belum_dinilai' => 0,
            'progress' => 0,
        ];
        
        $staffList = []; // Daftar anggota tim

        if ($myDivisi) {
            // Ambil semua staff di divisi ini (kecuali manajer itu sendiri jika dia terdaftar sebagai karyawan di situ)
            // Tapi biasanya manajer menilai semua bawahan.
            $staffs = Karyawan::where('id_divisi', $myDivisi->id_divisi)
                              ->where('id_user', '!=', $user->id_user) // Exclude diri sendiri (opsional)
                              ->where('status', true)
                              ->get();

            $stats['total_staff'] = $staffs->count();

            if ($periodeAktif) {
                foreach ($staffs as $staff) {
                    // Cek apakah staff ini sudah dinilai di periode ini?
                    $penilaian = PenilaianHeader::where('id_periode', $periodeAktif->id_periode)
                                                ->where('id_karyawan', $staff->id_karyawan)
                                                ->first();

                    $isDone = $penilaian ? true : false;
                    
                    if ($isDone) {
                        $stats['sudah_dinilai']++;
                    } else {
                        $stats['belum_dinilai']++;
                    }

                    // Masukkan ke list untuk ditampilkan di tabel
                    $staffList[] = (object) [
                        'id_karyawan' => $staff->id_karyawan,
                        'nama' => $staff->nama_lengkap,
                        'nik' => $staff->nik,
                        'foto' => $staff->foto,
                        'status_penilaian' => $isDone ? 'Sudah' : 'Belum',
                        'tanggal_dinilai' => $isDone ? $penilaian->created_at : null,
                        // Nanti kita butuh ID penilaian untuk tombol Edit, jika sudah ada
                        'id_penilaian' => $isDone ? $penilaian->id_penilaianHeader : null 
                    ];
                }

                // Hitung Persentase
                if ($stats['total_staff'] > 0) {
                    $stats['progress'] = round(($stats['sudah_dinilai'] / $stats['total_staff']) * 100);
                }
            }
        }

        return view('dashboard', compact('periodeAktif', 'stats', 'myDivisi', 'staffList')); 
    }

    private function dashboardKaryawan() 
    { 
        $user = Auth::user();
        
        // 1. Ambil Data Karyawan (Profile)
        $karyawan = Karyawan::with('divisi')->where('id_user', $user->id_user)->first();
        
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();

        $stats = [
            'status_periode_ini' => 'Menunggu', // Default
            'tanggal_dinilai' => null,
            'penilai' => '-',
            'total_history' => 0
        ];

        // 2. Cek Status Penilaian di Periode Aktif
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

        // 3. Ambil Riwayat Penilaian (History)
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