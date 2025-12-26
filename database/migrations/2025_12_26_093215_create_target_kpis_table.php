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
        Schema::create('target_kpis', function (Blueprint $table) {
            $table->id('id_target');
            $table->foreignId('id_indikator')->constrained('indikator_kpis', 'id_indikator')->onDelete('cascade');
            $table->string('nilai_target');
            $table->string('jenis_target')->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_kpis');
    }
};
