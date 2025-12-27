<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianDetail extends Model
{
    protected $primaryKey = 'id_penilaianDetail';

    protected $fillable = [
        'id_penilaianHeader',
        'id_indikator',
        'nilai_input',
    ];

    public function indikator()
    {
        return $this->belongsTo(IndikatorKpi::class, 'id_indikator', 'id_indikator');
    }
}
