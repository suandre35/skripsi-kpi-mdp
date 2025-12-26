<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_divisi';
    
    protected $fillable = [
        'nama_divisi',
        'deskripsi',
        'id_manajer',
        'status',
    ];

    public function manajer()
    {
        return $this->belongsTo(User::class, 'id_manajer', 'id_user');
    }
}
