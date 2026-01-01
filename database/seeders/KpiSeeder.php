<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriKpi;
use App\Models\IndikatorKpi;
use App\Models\BobotKpi;
use App\Models\TargetKpi;

class KpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // 1. BUAT KATEGORI KPI
        // ==========================================
        $this->command->info('📂 Membuat Kategori KPI...');
        
        $katOperasional = KategoriKpi::create(['nama_kategori' => 'Operasional & Logistik', 'deskripsi' => 'Efisiensi stok, pengiriman, dan manajemen gudang.', 'status' => true]);
        $katFinansial = KategoriKpi::create(['nama_kategori' => 'Finansial & Akuntansi', 'deskripsi' => 'Pengelolaan keuangan, laporan, dan kepatuhan pajak.', 'status' => true]);
        $katPelayanan = KategoriKpi::create(['nama_kategori' => 'Kualitas Pelayanan (Service)', 'deskripsi' => 'Kepuasan pelanggan dan kecepatan penanganan masalah.', 'status' => true]);
        $katPenjualan = KategoriKpi::create(['nama_kategori' => 'Penjualan & Store', 'deskripsi' => 'Pencapaian target omzet dan operasional toko.', 'status' => true]);
        $katDisiplin = KategoriKpi::create(['nama_kategori' => 'Kedisiplinan & SOP', 'deskripsi' => 'Absensi dan kepatuhan terhadap aturan perusahaan.', 'status' => true]);

        // =========================================================================
        // 2. SETUP KPI PER DIVISI
        // =========================================================================

        // -------------------------------------------------------------------------
        // A. DIVISI LOGISTIK (ID: 2) -> Total 100%
        // Target: Akurasi Stok (40%) + Pengiriman Tepat Waktu (40%) + Disiplin (20%)
        // -------------------------------------------------------------------------
        
        $this->command->info('🚚 Setup KPI Divisi Logistik...');
        
        $indLog1 = IndikatorKpi::create(['id_kategori' => $katOperasional->id_kategori, 'nama_indikator' => 'Akurasi Stok Opname Gudang', 'deskripsi' => 'Selisih stok fisik dan sistem harus minimal (mendekati 0).', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["2"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indLog1->id_indikator, 'nilai_bobot' => 40]);
        TargetKpi::create(['id_indikator' => $indLog1->id_indikator, 'nilai_target' => 98, 'jenis_target' => 'Maksimal']);

        $indLog2 = IndikatorKpi::create(['id_kategori' => $katOperasional->id_kategori, 'nama_indikator' => 'Ketepatan Waktu Pengiriman Barang', 'deskripsi' => 'Barang dikirim ke cabang/customer sesuai jadwal.', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["2"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indLog2->id_indikator, 'nilai_bobot' => 40]);
        TargetKpi::create(['id_indikator' => $indLog2->id_indikator, 'nilai_target' => 100, 'jenis_target' => 'Maksimal']);


        // -------------------------------------------------------------------------
        // B. DIVISI KEUANGAN (ID: 3) -> Total 100%
        // Target: Cash Flow (50%) + Efisiensi Biaya (30%) + Disiplin (20%)
        // -------------------------------------------------------------------------

        $this->command->info('💰 Setup KPI Divisi Keuangan...');

        $indKeu1 = IndikatorKpi::create(['id_kategori' => $katFinansial->id_kategori, 'nama_indikator' => 'Manajemen Cash Flow & Tagihan', 'deskripsi' => 'Memastikan tagihan dibayar tepat waktu dan cash flow stabil.', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["3"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indKeu1->id_indikator, 'nilai_bobot' => 50]);
        TargetKpi::create(['id_indikator' => $indKeu1->id_indikator, 'nilai_target' => 100, 'jenis_target' => 'Maksimal']);

        $indKeu2 = IndikatorKpi::create(['id_kategori' => $katFinansial->id_kategori, 'nama_indikator' => 'Efisiensi Anggaran Operasional', 'deskripsi' => 'Pengeluaran operasional tidak melebihi budget bulanan.', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["3"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indKeu2->id_indikator, 'nilai_bobot' => 30]);
        TargetKpi::create(['id_indikator' => $indKeu2->id_indikator, 'nilai_target' => 95, 'jenis_target' => 'Maksimal']);


        // -------------------------------------------------------------------------
        // C. DIVISI ACCOUNTING (ID: 4) -> Total 100%
        // Target: Laporan Neraca (40%) + Audit/Pajak (40%) + Disiplin (20%)
        // -------------------------------------------------------------------------

        $this->command->info('📊 Setup KPI Divisi Accounting...');

        $indAcc1 = IndikatorKpi::create(['id_kategori' => $katFinansial->id_kategori, 'nama_indikator' => 'Ketepatan Waktu Laporan Neraca & Laba Rugi', 'deskripsi' => 'Laporan bulanan selesai sebelum tanggal 10.', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["4"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indAcc1->id_indikator, 'nilai_bobot' => 40]);
        TargetKpi::create(['id_indikator' => $indAcc1->id_indikator, 'nilai_target' => 100, 'jenis_target' => 'Maksimal']);

        $indAcc2 = IndikatorKpi::create(['id_kategori' => $katFinansial->id_kategori, 'nama_indikator' => 'Kepatuhan Pelaporan Pajak', 'deskripsi' => 'Tidak ada denda keterlambatan pelaporan pajak.', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["4"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indAcc2->id_indikator, 'nilai_bobot' => 40]);
        TargetKpi::create(['id_indikator' => $indAcc2->id_indikator, 'nilai_target' => 100, 'jenis_target' => 'Maksimal']);


        // -------------------------------------------------------------------------
        // D. DIVISI SERVICE (ID: 5) -> Total 100%
        // Target: CSAT (40%) + Kecepatan Repair (40%) + Disiplin (20%)
        // -------------------------------------------------------------------------

        $this->command->info('🔧 Setup KPI Divisi Service...');

        $indSer1 = IndikatorKpi::create(['id_kategori' => $katPelayanan->id_kategori, 'nama_indikator' => 'Rating Kepuasan Pelanggan (CSAT)', 'deskripsi' => 'Rata-rata bintang dari customer setelah servis.', 'satuan_pengukuran' => 'Skala 1-5', 'target_divisi' => ["5"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indSer1->id_indikator, 'nilai_bobot' => 40]);
        TargetKpi::create(['id_indikator' => $indSer1->id_indikator, 'nilai_target' => 4.5, 'jenis_target' => 'Maksimal']);

        $indSer2 = IndikatorKpi::create(['id_kategori' => $katPelayanan->id_kategori, 'nama_indikator' => 'Penyelesaian Tiket Sesuai SLA', 'deskripsi' => 'Servis selesai dalam waktu 24-48 jam sesuai standar.', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["5"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indSer2->id_indikator, 'nilai_bobot' => 40]);
        TargetKpi::create(['id_indikator' => $indSer2->id_indikator, 'nilai_target' => 90, 'jenis_target' => 'Maksimal']);


        // -------------------------------------------------------------------------
        // E. DIVISI STORE (ID: 6) -> Total 100%
        // Target: Omzet (50%) + Kebersihan/Display (30%) + Disiplin (20%)
        // -------------------------------------------------------------------------

        $this->command->info('🏪 Setup KPI Divisi Store...');

        $indSto1 = IndikatorKpi::create(['id_kategori' => $katPenjualan->id_kategori, 'nama_indikator' => 'Pencapaian Target Penjualan (Omzet)', 'deskripsi' => 'Realisasi penjualan harian/bulanan dibanding target.', 'satuan_pengukuran' => 'Persentase', 'target_divisi' => ["6"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indSto1->id_indikator, 'nilai_bobot' => 50]);
        TargetKpi::create(['id_indikator' => $indSto1->id_indikator, 'nilai_target' => 100, 'jenis_target' => 'Maksimal']);

        $indSto2 = IndikatorKpi::create(['id_kategori' => $katPenjualan->id_kategori, 'nama_indikator' => 'Kebersihan Toko & Kerapian Display', 'deskripsi' => 'Nilai audit kebersihan dan tata letak barang (Planogram).', 'satuan_pengukuran' => 'Skala 1-100', 'target_divisi' => ["6"], 'status' => true]);
        BobotKpi::create(['id_indikator' => $indSto2->id_indikator, 'nilai_bobot' => 30]);
        TargetKpi::create(['id_indikator' => $indSto2->id_indikator, 'nilai_target' => 90, 'jenis_target' => 'Maksimal']);


        // =========================================================================
        // 3. SETUP KPI UMUM (SHARED - SEMUA DIVISI) -> 20% SISA
        // =========================================================================

        $this->command->info('🌍 Setup KPI Umum (Kedisiplinan)...');

        $indUmum = IndikatorKpi::create([
            'id_kategori'       => $katDisiplin->id_kategori,
            'nama_indikator'    => 'Tingkat Kehadiran & Ketepatan Waktu',
            'deskripsi'         => 'Kehadiran full, tidak telat, dan mengikuti aturan jam kerja.',
            'satuan_pengukuran' => 'Persentase',
            'target_divisi'     => ["2", "3", "4", "5", "6"], // Logistik, Keu, Acc, Ser, Sto
            'status'            => true
        ]);
        
        // Bobot 20% berlaku untuk semua divisi yang punya indikator ini
        BobotKpi::create(['id_indikator' => $indUmum->id_indikator, 'nilai_bobot' => 20]);
        TargetKpi::create(['id_indikator' => $indUmum->id_indikator, 'nilai_target' => 100, 'jenis_target' => 'Maksimal']);

        $this->command->info('✅ Master Data KPI berhasil dibuat lengkap!');
    }
}