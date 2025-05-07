<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Barang;
use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $total_kunjungan = Kunjungan::count();
        $kunjungan_bulan_ini = Kunjungan::whereMonth('tanggal_kunjungan', Carbon::now()->month)
            ->whereYear('tanggal_kunjungan', Carbon::now()->year)
            ->count();
        $kunjungan_hari_ini = Kunjungan::whereDate('tanggal_kunjungan', Carbon::now()->toDateString())->count();

        // Statistik status kunjungan
        $status_counts = Kunjungan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Data untuk chart kunjungan per bulan
        $kunjungan_per_bulan = Kunjungan::select(
            DB::raw('MONTH(tanggal_kunjungan) as bulan'),
            DB::raw('YEAR(tanggal_kunjungan) as tahun'),
            DB::raw('count(*) as total')
        )
            ->whereYear('tanggal_kunjungan', Carbon::now()->year)
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $bulan_labels = [];
        $bulan_data = [];

        foreach ($kunjungan_per_bulan as $data) {
            $bulan_labels[] = Carbon::createFromDate(null, $data->bulan, 1)->locale('id')->monthName;
            $bulan_data[] = $data->total;
        }

        return view('admin.laporan.index', compact(
            'total_kunjungan',
            'kunjungan_bulan_ini',
            'kunjungan_hari_ini',
            'status_counts',
            'bulan_labels',
            'bulan_data'
        ));
    }

    public function kunjungan(Request $request)
    {
        $query = Kunjungan::with(['santri', 'waliSantri']);

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('tanggal_kunjungan', [$start, $end]);
        } elseif ($request->has('start_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $query->where('tanggal_kunjungan', '>=', $start);
        } elseif ($request->has('end_date')) {
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->where('tanggal_kunjungan', '<=', $end);
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $kunjungan = $query->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->paginate(15);

        return view('admin.laporan.kunjungan', compact('kunjungan'));
    }

    public function barang(Request $request)
    {
        $query = Barang::with(['kunjungan.santri', 'kunjungan.waliSantri']);

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereHas('kunjungan', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal_kunjungan', [$start, $end]);
            });
        } elseif ($request->has('start_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $query->whereHas('kunjungan', function ($q) use ($start) {
                $q->where('tanggal_kunjungan', '>=', $start);
            });
        } elseif ($request->has('end_date')) {
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereHas('kunjungan', function ($q) use ($end) {
                $q->where('tanggal_kunjungan', '<=', $end);
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $barang = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.laporan.barang', compact('barang'));
    }

    public function generatePdf($type, Request $request)
    {
        if ($type == 'kunjungan') {
            $query = Kunjungan::with(['santri', 'waliSantri']);

            // Filter by date range
            if ($request->has('start_date') && $request->has('end_date')) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('tanggal_kunjungan', [$start, $end]);
            }

            // Filter by status
            if ($request->has('status') && $request->status != 'all') {
                $query->where('status', $request->status);
            }

            $kunjungan = $query->orderBy('tanggal_kunjungan', 'desc')
                ->orderBy('jam_kunjungan', 'desc')
                ->get();

            $pdf = Pdf::loadView('admin.laporan.pdf.kunjungan', compact('kunjungan'));
            return $pdf->download('laporan-kunjungan.pdf');
        } elseif ($type == 'barang') {
            $query = Barang::with(['kunjungan.santri', 'kunjungan.waliSantri']);

            // Filter by date range
            if ($request->has('start_date') && $request->has('end_date')) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
                $query->whereHas('kunjungan', function ($q) use ($start, $end) {
                    $q->whereBetween('tanggal_kunjungan', [$start, $end]);
                });
            }

            // Filter by status
            if ($request->has('status') && $request->status != 'all') {
                $query->where('status', $request->status);
            }

            $barang = $query->orderBy('created_at', 'desc')->get();

            $pdf = Pdf::loadView('admin.laporan.pdf.barang', compact('barang'));
            return $pdf->download('laporan-barang.pdf');
        }

        return redirect()->back()->with('error', 'Tipe laporan tidak valid.');
    }

    public function generateExcel($type, Request $request)
    {
        // Implementasi export ke Excel
        return redirect()->back()->with('info', 'Fitur export Excel masih dalam pengembangan.');
    }
}
