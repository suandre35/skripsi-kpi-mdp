<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndikatorKPI extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'id_kategori',
        'nama_indikator',
        'deskripsi',
        'satuan_pengukuran',
        'status',
    ];

    public function kategori()
    {
        return $this->belongTo(KategoriKpi::class, 'id_kategori', 'id_kategori');
    }
}
