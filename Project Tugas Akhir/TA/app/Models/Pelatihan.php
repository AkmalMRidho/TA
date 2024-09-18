<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'tendik_id',
        'nama_pelatihan',
        'expired_sertifikat',
        'sertifikat_path',
        'user_id',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'dosen_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function tendik()
    {
        return $this->belongsTo(Tendik::class, 'tendik_id', 'tendik_id');
    }

    public function isExpired()
    {
        return Carbon::now()->gt(Carbon::parse($this->expired_sertifikat));
    }

    public function isExpiringSoon($days)
    {
        return Carbon::now()->addDays($days)->gte(Carbon::parse($this->expired_sertifikat));
    }
}
