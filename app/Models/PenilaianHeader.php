<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianHeader extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_penilaianHeader';

    protected $fillable = [
        'id_karyawan',
        'id_periode',
        'id_penilai',
        'tanggal_penilaian',
        'total_nilai',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeEvaluasi::class, 'id_periode', 'id_periode');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'id_penilai', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_penilaianHeader', 'id_penilaianHeader');
    }
}
