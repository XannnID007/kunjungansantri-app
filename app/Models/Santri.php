<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $fillable = [
        'nis',
        'nama',
        'kamar',
        'jenis_kelamin',
        'alamat',
        'foto',
        'is_active',
    ];

    public function waliSantri()
    {
        return $this->belongsToMany(WaliSantri::class, 'relasi_santri_wali', 'santri_id', 'wali_id')
            ->withTimestamps();
    }

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class);
    }
}
