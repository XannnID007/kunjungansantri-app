<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kunjungan_id',
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'jumlah',
        'foto',
        'status',
        'alasan_ditolak',
        'waktu_diserahkan',
        'waktu_diterima',
    ];

    protected $casts = [
        'waktu_diserahkan' => 'datetime',
        'waktu_diterima' => 'datetime',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'diserahkan' => '<span class="badge bg-info">Diserahkan</span>',
            'diterima' => '<span class="badge bg-success">Diterima</span>',
            'dikembalikan' => '<span class="badge bg-secondary">Dikembalikan</span>',
            'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
        ];

        return $labels[$this->status] ?? '';
    }
}
