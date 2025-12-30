<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BobotKpi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_bobot';

    protected $fillable = [
        'id_indikator',
        'nilai_bobot',
    ];

    // Relasi ke Indikator
    public function indikator()
    {
        return $this->belongsTo(IndikatorKpi::class, 'id_indikator', 'id_indikator');
    }
}
