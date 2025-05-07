<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WaliSantri;
use App\Models\User;
use App\Models\RelasiSantriWali;
use App\Models\Santri;

class WaliSantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Wali dengan smartphone (terkait dengan user)
        $wali1 = WaliSantri::create([
            'user_id' => User::where('email', 'ahmad@example.com')->first()->id,
            'nama' => 'Ahmad Santoso',
            'no_identitas' => '3273012345678901',
            'no_hp' => '08123456789',
            'has_smartphone' => true,
            'alamat' => 'Jl. Contoh No. 123, Bandung',
            'foto' => null,
            'hubungan' => 'Ayah',
        ]);

        // Wali tanpa smartphone (tidak terkait dengan user)
        $wali2 = WaliSantri::create([
            'user_id' => null,
            'nama' => 'Budi Setiawan',
            'no_identitas' => '3273012345678902',
            'no_hp' => '08123456790',
            'has_smartphone' => false,
            'alamat' => 'Jl. Sample No. 456, Bandung',
            'foto' => null,
            'hubungan' => 'Ayah',
        ]);

        // Wali ketiga
        $wali3 = WaliSantri::create([
            'user_id' => null,
            'nama' => 'Siti Rahayu',
            'no_identitas' => '3273012345678903',
            'no_hp' => '08123456791',
            'has_smartphone' => false,
            'alamat' => 'Jl. Test No. 789, Bandung',
            'foto' => null,
            'hubungan' => 'Ibu',
        ]);

        // Relasi Wali dan Santri
        RelasiSantriWali::create([
            'santri_id' => Santri::where('nis', 'S001')->first()->id,
            'wali_id' => $wali1->id,
        ]);

        RelasiSantriWali::create([
            'santri_id' => Santri::where('nis', 'S002')->first()->id,
            'wali_id' => $wali2->id,
        ]);

        RelasiSantriWali::create([
            'santri_id' => Santri::where('nis', 'S003')->first()->id,
            'wali_id' => $wali3->id,
        ]);
    }
}
