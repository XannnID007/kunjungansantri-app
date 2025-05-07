<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'jenis',
        'is_read',
        'waktu_kirim',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'waktu_kirim' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
