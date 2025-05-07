<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalOperasional;

class JadwalOperasionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwal = [
            [
                'hari' => 'Senin',
                'jam_buka' => '09:00',
                'jam_tutup' => '12:00',
                'kuota_kunjungan' => 20,
                'is_active' => true,
                'catatan' => 'Kunjungan reguler',
            ],
            [
                'hari' => 'Senin',
                'jam_buka' => '14:00',
                'jam_tutup' => '16:00',
                'kuota_kunjungan' => 15,
                'is_active' => true,
                'catatan' => 'Kunjungan sore',
            ],
            [
                'hari' => 'Kamis',
                'jam_buka' => '09:00',
                'jam_tutup' => '12:00',
                'kuota_kunjungan' => 20,
                'is_active' => true,
                'catatan' => 'Kunjungan reguler',
            ],
            [
                'hari' => 'Kamis',
                'jam_buka' => '14:00',
                'jam_tutup' => '16:00',
                'kuota_kunjungan' => 15,
                'is_active' => true,
                'catatan' => 'Kunjungan sore',
            ],
            [
                'hari' => 'Minggu',
                'jam_buka' => '09:00',
                'jam_tutup' => '15:00',
                'kuota_kunjungan' => 30,
                'is_active' => true,
                'catatan' => 'Kunjungan akhir pekan',
            ],
        ];

        foreach ($jadwal as $data) {
            JadwalOperasional::create($data);
        }
    }
}
