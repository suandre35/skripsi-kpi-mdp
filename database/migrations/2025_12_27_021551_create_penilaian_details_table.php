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
            $table->foreignId('id_penilaianHeader')->constrained('penilaian_headers', 'id_penilaianHeader')->onDelete('cascade');
            $table->foreignId('id_indikator')->constrained('indikator_kpis', 'id_indikator');
            $table->integer('nilai_input');
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
