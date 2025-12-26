<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodeEvaluasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'nama_periode', 
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_pengumuman',
        'status',
    ];
    
    protected $casts = [
        'tanggal_mulai'      => 'datetime',
        'tanggal_selesai'    => 'datetime',
        'tanggal_pengumuman' => 'datetime',
    ];
}
