<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $kunjungan_hari_ini = Kunjungan::where('tanggal_kunjungan', $today)->count();
        $kunjungan_berlangsung = Kunjungan::where('tanggal_kunjungan', $today)
            ->where('status', 'in_progress')
            ->count();
        $kunjungan_selesai = Kunjungan::where('tanggal_kunjungan', $today)
            ->where('status', 'completed')
            ->count();
        $kunjungan_menunggu = Kunjungan::where('tanggal_kunjungan', $today)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->count();

        $barang_hari_ini = Barang::whereHas('kunjungan', function ($query) use ($today) {
            $query->where('tanggal_kunjungan', $today);
        })->count();

        $kunjungan_terbaru = Kunjungan::with(['santri', 'waliSantri'])
            ->where('tanggal_kunjungan', $today)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $barang_terbaru = Barang::with(['kunjungan.santri', 'kunjungan.waliSantri'])
            ->whereHas('kunjungan', function ($query) use ($today) {
                $query->where('tanggal_kunjungan', $today);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('petugas.dashboard', compact(
            'kunjungan_hari_ini',
            'kunjungan_berlangsung',
            'kunjungan_selesai',
            'kunjungan_menunggu',
            'barang_hari_ini',
            'kunjungan_terbaru',
            'barang_terbaru'
        ));
    }
}
