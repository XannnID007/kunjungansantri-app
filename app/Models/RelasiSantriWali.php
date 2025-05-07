<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiSantriWali extends Model
{
    use HasFactory;

    protected $table = 'relasi_santri_wali';

    protected $fillable = [
        'santri_id',
        'wali_id',
    ];
}
