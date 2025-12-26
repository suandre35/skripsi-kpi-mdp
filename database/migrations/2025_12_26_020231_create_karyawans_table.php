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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->foreignId('id_user')->unique()->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_divisi')->nullable() ->constrained('divisis', 'id_divisi')->onDelete('set null');
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->date('tanggal_masuk')->nullable();
            $table->enum('status_karyawan', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
        Schema::table('divisis', function (Blueprint $table) {
            $table->foreign('id_kepala_divisi')
                  ->references('id_karyawan')
                  ->on('karyawans')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisis', function (Blueprint $table) {
            $table->dropForeign(['id_kepala_divisi']);
        });
        Schema::dropIfExists('karyawans');
    }
};
