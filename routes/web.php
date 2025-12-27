<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriKpiController;
use App\Http\Controllers\IndikatorKpiController;
use App\Http\Controllers\BobotKpiController;
use App\Http\Controllers\TargetKpiController;
use App\Http\Controllers\PeriodeEvaluasiController;
use App\Http\Controllers\PenilaianController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
});


// =================================================================
// 2. GRUP KHUSUS MANAJER (TRANSAKSI PENILAIAN)
// =================================================================
Route::middleware(['auth', 'role:Manajer'])->group(function () {
    
    Route::resource('penilaian', PenilaianController::class);

});

require __DIR__.'/auth.php';
