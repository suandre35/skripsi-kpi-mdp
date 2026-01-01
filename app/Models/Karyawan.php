<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'id_user',
        'id_divisi',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'email',
        'foto',
        'tanggal_masuk',
        'status',
    ];

    // Relasi: Karyawan milik satu User (Akun Login)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi: Karyawan bekerja di satu Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id_divisi');
    }
}