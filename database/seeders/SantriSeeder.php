<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $santri = [
            [
                'nis' => 'S001',
                'nama' => 'Muhammad Faiz',
                'kamar' => 'A-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Contoh No. 123, Bandung',
                'foto' => null,
                'is_active' => true,
            ],
            [
                'nis' => 'S002',
                'nama' => 'Abdullah Malik',
                'kamar' => 'A-02',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Sample No. 456, Bandung',
                'foto' => null,
                'is_active' => true,
            ],
            [
                'nis' => 'S003',
                'nama' => 'Zahra Putri',
                'kamar' => 'B-01',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Test No. 789, Bandung',
                'foto' => null,
                'is_active' => true,
            ],
        ];

        foreach ($santri as $data) {
            Santri::create($data);
        }
    }
}
