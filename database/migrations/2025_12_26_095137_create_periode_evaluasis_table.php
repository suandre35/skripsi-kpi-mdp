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
        Schema::create('periode_evaluasis', function (Blueprint $table) {
            $table->id('id_periode');
            $table->string('nama_periode');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->dateTime('tanggal_pengumuman');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Nonaktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_evaluasis');
    }
};
