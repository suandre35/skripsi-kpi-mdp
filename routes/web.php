<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriKpiController;
use App\Http\Controllers\IndikatorKpiController;
use App\Http\Controllers\BobotKpiController;
use App\Http\Controllers\TargetKpiController;
use App\Http\Controllers\PeriodeEvaluasiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\LaporanHrdController;
use App\Http\Controllers\KeamananController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =================================================================
// 1. GRUP KHUSUS HRD (MASTER DATA)
// =================================================================
Route::middleware(['auth', 'role:HRD'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('divisi', DivisiController::class);
    Route::resource('karyawan', KaryawanController::class);
    
    // Master Data KPI
    Route::resource('kategori', KategoriKpiController::class);
    Route::resource('indikator', IndikatorKpiController::class);
    Route::resource('bobot', BobotKpiController::class);
    Route::resource('target', TargetKpiController::class);
    Route::resource('periode', PeriodeEvaluasiController::class);
    Route::resource('penilaian', PenilaianController::class);
    
    // Laporan Nilai
    Route::get('/laporan', [LaporanHrdController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/{karyawan}/{periode}', [LaporanHrdController::class, 'show'])->name('admin.laporan.show');

    Route::get('/ranking-kpi', [LaporanHrdController::class, 'ranking'])->name('admin.ranking.index');

    // FITUR KEAMANAN
    Route::prefix('keamanan')->name('keamanan.')->group(function () {
        Route::get('/riwayat-penilaian', [KeamananController::class, 'riwayatPenilaian'])->name('riwayat');
        Route::get('/aktivitas-user', [KeamananController::class, 'aktivitasUser'])->name('aktivitas');
    });
});


// =================================================================
// 2. GRUP KHUSUS MANAJER (TRANSAKSI PENILAIAN)
// =================================================================
Route::middleware(['auth', 'role:Manajer'])->group(function () {
    
    Route::resource('penilaian', PenilaianController::class);

    // Rapor Tim (Manajer)
    Route::get('/laporan-kpi', [PenilaianController::class, 'laporan'])->name('penilaian.laporan');
    Route::get('/laporan-kpi/{id_karyawan}', [PenilaianController::class, 'detailLaporan'])->name('penilaian.detailLaporan');
});

// =================================================================
// 3. GRUP KHUSUS KARYAWAN (RAPOR PRIBADI)
// =================================================================
Route::middleware(['auth', 'role:Karyawan'])->group(function () {
    Route::get('/rapor-saya', [App\Http\Controllers\KaryawanPanelController::class, 'index'])->name('karyawan.rapor');
});

require __DIR__.'/auth.php';
