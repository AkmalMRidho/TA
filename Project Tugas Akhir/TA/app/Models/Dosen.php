<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'tanggal_lahir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mataKuliahDosen()
    {
        return $this->hasMany(MataKuliahDosen::class, 'dosen_id');
    }

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'dosen_id');
    }

    public function riwayatPendidikan()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'dosen_id');
    }

    public function keterampilan()
    {
        return $this->hasMany(Keterampilan::class);
        
    }

    public function evaluations()
    {
    return $this->hasMany(Evaluation::class);
    }
}

