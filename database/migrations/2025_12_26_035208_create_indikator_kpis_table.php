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
            $table->json('target_divisi');
            $table->string('nama_indikator');
            $table->text('deskripsi')->nullable();
            $table->string('satuan_pengukuran')->nullable();
            $table->boolean('status')->default(true);
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
