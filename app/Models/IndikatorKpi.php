<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndikatorKpi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'id_kategori',
        'nama_indikator',
        'deskripsi',
        'satuan_pengukuran',
        'target_divisi',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriKpi::class, 'id_kategori', 'id_kategori');
    }
    public function bobot()
    {
        return $this->hasMany(BobotKpi::class, 'id_indikator', 'id_indikator');
    }
    public function target()
    {
        return $this->hasOne(TargetKpi::class, 'id_indikator', 'id_indikator');
    }
    protected $casts = [
        'target_divisi' => 'array',
    ];
}
