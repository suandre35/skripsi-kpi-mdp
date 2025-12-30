<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TargetKpi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_target';

    protected $fillable = [
        'id_indikator',
        'nilai_target',
        'jenis_target',
    ];

    public function indikator()
    {
        return $this->belongsTo(IndikatorKpi::class, 'id_indikator', 'id_indikator');
    }
}
