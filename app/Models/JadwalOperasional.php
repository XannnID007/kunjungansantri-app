<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalOperasional extends Model
{
    use HasFactory;

    protected $table = 'jadwal_operasional';

    protected $fillable = [
        'hari',
        'jam_buka',
        'jam_tutup',
        'kuota_kunjungan',
        'is_active',
        'catatan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getJamOperasionalAttribute()
    {
        return $this->jam_buka . ' - ' . $this->jam_tutup;
    }
}
