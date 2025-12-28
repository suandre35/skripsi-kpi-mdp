<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian_details', function (Blueprint $table) {
            $table->id('id_penilaianDetail');
            
            // Relasi ke Header (Rapor Karyawan)
            $table->foreignId('id_penilaianHeader')
                  ->constrained('penilaian_headers', 'id_penilaianHeader')
                  ->onDelete('cascade');
            
            // Relasi ke Indikator (Apa yang dikerjakan)
            $table->foreignId('id_indikator')
                  ->constrained('indikator_kpis', 'id_indikator')
                  ->onDelete('cascade');
            
            // --- KOLOM KHUSUS LOG HARIAN ---
            $table->date('tanggal'); // Tanggal pengerjaan (misal: 28 Des)
            $table->decimal('nilai_input', 15, 2); // Hasil kerja (misal: 5000000 atau 10)
            $table->text('catatan')->nullable(); // Catatan (misal: "Ada kendala hujan")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_details');
    }
};
