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
        Schema::create('indikator_kpis', function (Blueprint $table) {
            $table->id('id_indikator');
            $table->foreignId('id_kategori')->constrained('kategori_kpis', 'id_kategori')->onDelete('cascade');
            $table->foreignId('id_divisi')->constrained('divisis', 'id_divisi')->onDelete('cascade');
            $table->string('nama_indikator');
            $table->text('deskripsi')->nullable();
            $table->string('satuan_pengukuran')->nullable();
            $table->enum('status', ['Aktif','Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_kpis');
    }
};
