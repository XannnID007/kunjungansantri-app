<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliSantri extends Model
{
    use HasFactory;

    protected $table = 'wali_santri';

    protected $fillable = [
        'user_id',
        'nama',
        'no_identitas',
        'no_hp',
        'has_smartphone',
        'alamat',
        'foto',
        'hubungan',
    ];

    protected $casts = [
        'has_smartphone' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function santri()
    {
        return $this->belongsToMany(Santri::class, 'relasi_santri_wali', 'wali_id', 'santri_id')
            ->withTimestamps();
    }

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'wali_id');
    }
}
