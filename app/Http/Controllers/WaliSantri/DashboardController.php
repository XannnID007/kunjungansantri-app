<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\JadwalOperasional;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return view('wali.dashboard')->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        $santri_list = $wali->santri;

        $kunjungan_terbaru = Kunjungan::with(['santri'])
            ->where('wali_id', $wali->id)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->limit(5)
            ->get();

        $kunjungan_aktif = Kunjungan::with(['santri'])
            ->where('wali_id', $wali->id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'in_progress'])
            ->where('tanggal_kunjungan', '>=', Carbon::today())
            ->orderBy('tanggal_kunjungan')
            ->orderBy('jam_kunjungan')
            ->first();

        $jadwal_operasional = JadwalOperasional::where('is_active', true)
            ->orderBy('hari')
            ->orderBy('jam_buka')
            ->get()
            ->groupBy('hari');

        return view('wali.dashboard', compact(
            'wali',
            'santri_list',
            'kunjungan_terbaru',
            'kunjungan_aktif',
            'jadwal_operasional'
        ));
    }
}
