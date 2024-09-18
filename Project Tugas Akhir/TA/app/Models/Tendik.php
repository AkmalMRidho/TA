<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tendik extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'jabatan',
        'tanggal_lahir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'tendik_id');
    }

    public function riwayatPendidikan()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'tendik_id');
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
