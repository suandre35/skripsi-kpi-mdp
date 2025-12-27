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
        Schema::create('penilaian_headers', function (Blueprint $table) {
            $table->id('id_penilaianHeader');
            $table->foreignId('id_karyawan')->constrained('karyawans', 'id_karyawan')->onDelete('cascade');
            $table->foreignId('id_periode')->constrained('periode_evaluasis', 'id_periode')->onDelete('cascade');
            $table->foreignId('id_penilai')->constrained('users', 'id_user');
            $table->date('tanggal_penilaian');
            $table->decimal('total_nilai', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_headers');
    }
};
