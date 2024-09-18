<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keterampilan extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'tendik_id',
        'golongan',
        'pangkat',
        'umur',
        'lama_jabatan',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'dosen_id');
    }

    public function tendik()
    {
        return $this->belongsTo(Tendik::class, 'tendik_id', 'tendik_id');
    }
}

