<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Santri;
use App\Models\WaliSantri;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_santri = Santri::where('is_active', true)->count();
        $total_wali = WaliSantri::count();
        $total_pengguna = User::count();

        $kunjungan_hari_ini = Kunjungan::whereDate('tanggal_kunjungan', now()->format('Y-m-d'))->count();
        $kunjungan_minggu_ini = Kunjungan::whereBetween('tanggal_kunjungan', [
            now()->startOfWeek()->format('Y-m-d'),
            now()->endOfWeek()->format('Y-m-d')
        ])->count();

        $recent_kunjungan = Kunjungan::with(['santri', 'waliSantri'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $data_kunjungan_bulanan = Kunjungan::selectRaw('COUNT(*) as total, DATE_FORMAT(tanggal_kunjungan, "%m-%Y") as bulan')
            ->whereYear('tanggal_kunjungan', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get();

        $labels = [];
        $data = [];

        foreach ($data_kunjungan_bulanan as $item) {
            $month = date('M', mktime(0, 0, 0, explode('-', $item->bulan)[0], 1));
            $labels[] = $month;
            $data[] = $item->total;
        }

        return view('admin.dashboard', compact(
            'total_santri',
            'total_wali',
            'total_pengguna',
            'kunjungan_hari_ini',
            'kunjungan_minggu_ini',
            'recent_kunjungan',
            'labels',
            'data'
        ));
    }
}
