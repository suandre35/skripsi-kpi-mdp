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
        Schema::create('bobot_kpis', function (Blueprint $table) {
            $table->id('id_bobot');
            $table->foreignId('id_indikator')->constrained('indikator_kpis', 'id_indikator')->onDelete('cascade');
            $table->integer('nilai_bobot');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_kpis');
    }
};
