<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianDetail extends Model
{
    protected $primaryKey = 'id_penilaianDetail';

    protected $fillable = [
        'id_penilaianHeader',
        'id_indikator',
        'nilai_input',
        'tanggal',
        'catatan',
    ];

    public function indikator()
    {
        return $this->belongsTo(IndikatorKpi::class, 'id_indikator', 'id_indikator');
    }
    
    public function header()
    {
        return $this->belongsTo(PenilaianHeader::class, 'id_penilaianHeader', 'id_penilaianHeader');
    }
}
