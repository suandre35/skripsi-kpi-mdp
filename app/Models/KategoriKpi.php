<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriKpi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'status',
    ];

    public function indikators()
    {
        return $this->hasMany(IndikatorKpi::class, 'id_kategori', 'id_kategori');
    }
}
