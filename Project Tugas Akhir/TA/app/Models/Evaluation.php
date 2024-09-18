<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dosen_id',
        'tendik_id',
        'riwayat_pendidikan',
        'pelatihan',
        'golongan',
        'pangkat',
        'umur',
        'Pro_Act',
        'jumlah',
        'kompetensi',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function tendik()
    {
        return $this->belongsTo(Tendik::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'pelatihan' => 'array',
    ];
}
