<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_divisi'; // Penting! Karena bukan 'id'
    
    protected $fillable = [
        'nama_divisi',
        'deskripsi',
        'id_kepala_divisi',
    ];

    public function anggotas()
    {
        return $this->hasMany(Karyawan::class, 'id_divisi', 'id_divisi');
    }

    public function kepalaDivisi()
    {
        return $this->belongsTo(Karyawan::class, 'id_kepala_divisi', 'id_karyawan');
    }
}
