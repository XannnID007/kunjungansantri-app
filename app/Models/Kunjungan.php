<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';

    protected $fillable = [
        'kode_kunjungan',
        'wali_id',
        'santri_id',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'waktu_kedatangan',
        'waktu_selesai',
        'estimasi_durasi',
        'nomor_antrian',
        'status',
        'tujuan_kunjungan',
        'catatan',
        'is_preregistered',
        'registered_by',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'jam_kunjungan' => 'datetime',
        'waktu_kedatangan' => 'datetime',
        'waktu_selesai' => 'datetime',
        'is_preregistered' => 'boolean',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function waliSantri()
    {
        return $this->belongsTo(WaliSantri::class, 'wali_id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function getDurasiAttribute()
    {
        if ($this->waktu_kedatangan && $this->waktu_selesai) {
            return $this->waktu_selesai->diffInMinutes($this->waktu_kedatangan);
        }

        return $this->estimasi_durasi;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => '<span class="badge bg-warning">Menunggu</span>',
            'confirmed' => '<span class="badge bg-info">Terkonfirmasi</span>',
            'checked_in' => '<span class="badge bg-primary">Check In</span>',
            'in_progress' => '<span class="badge bg-success">Berlangsung</span>',
            'completed' => '<span class="badge bg-secondary">Selesai</span>',
            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>',
        ];

        return $labels[$this->status] ?? '';
    }
}
