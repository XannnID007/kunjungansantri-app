<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Services\FIFOQueueManager;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AntrianController extends Controller
{
    protected $queueManager;

    public function __construct(FIFOQueueManager $queueManager)
    {
        $this->queueManager = $queueManager;
    }

    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $current_time = Carbon::now()->format('H:i:s');

        $kunjungan_hari_ini = Kunjungan::with(['santri', 'waliSantri'])
            ->where('tanggal_kunjungan', $today)
            ->orderBy('jam_kunjungan', 'asc')
            ->orderBy('nomor_antrian', 'asc')
            ->get()
            ->groupBy('jam_kunjungan');

        $current_kunjungan = Kunjungan::with(['santri', 'waliSantri'])
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'in_progress')
            ->get();

        return view('petugas.antrian.index', compact(
            'kunjungan_hari_ini',
            'current_kunjungan',
            'current_time',
            'today'
        ));
    }

    public function nextQueue(Request $request)
    {
        $jam_kunjungan = $request->jam_kunjungan;
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');

        $next_visit = $this->queueManager->processNextVisit($tanggal, $jam_kunjungan);

        if ($next_visit) {
            return redirect()->back()->with('success', 'Kunjungan berikutnya diproses: ' . $next_visit->kode_kunjungan);
        }

        return redirect()->back()->with('info', 'Tidak ada antrian yang tersedia');
    }

    public function checkIn(Request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;

        $kunjungan = Kunjungan::where('kode_kunjungan', $kode_kunjungan)->first();

        if (!$kunjungan) {
            return redirect()->back()->with('error', 'Kunjungan tidak ditemukan');
        }

        if ($kunjungan->status == 'confirmed') {
            $kunjungan->update([
                'status' => 'checked_in',
                'waktu_kedatangan' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Check-in berhasil untuk kunjungan: ' . $kunjungan->kode_kunjungan);
        }

        return redirect()->back()->with('warning', 'Kunjungan tidak dapat di-check-in. Status saat ini: ' . $kunjungan->status);
    }

    public function complete(Request $request, $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        if ($kunjungan->status == 'in_progress') {
            $kunjungan->update([
                'status' => 'completed',
                'waktu_selesai' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Kunjungan telah diselesaikan: ' . $kunjungan->kode_kunjungan);
        }

        return redirect()->back()->with('warning', 'Kunjungan tidak dapat diselesaikan. Status saat ini: ' . $kunjungan->status);
    }

    public function cancel(Request $request, $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $kunjungan->update([
            'status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Kunjungan telah dibatalkan: ' . $kunjungan->kode_kunjungan);
    }

    public function registerWalk(Request $request)
    {
        $request->validate([
            'wali_id' => 'required|exists:wali_santri,id',
            'santri_id' => 'required|exists:santri,id',
            'tujuan_kunjungan' => 'required|string',
        ]);

        // Generate kode kunjungan
        $kode_kunjungan = 'KJG-' . strtoupper(substr(md5(time()), 0, 6));

        // Hitung nomor antrian
        $today = Carbon::now()->format('Y-m-d');
        $current_time = Carbon::now()->format('H:i:s');
        $nomor_antrian = $this->queueManager->generateQueueNumber($today, $current_time);

        // Buat kunjungan walk-in
        $kunjungan = Kunjungan::create([
            'kode_kunjungan' => $kode_kunjungan,
            'wali_id' => $request->wali_id,
            'santri_id' => $request->santri_id,
            'tanggal_kunjungan' => $today,
            'jam_kunjungan' => $current_time,
            'waktu_kedatangan' => Carbon::now(),
            'estimasi_durasi' => 30, // Default 30 menit
            'nomor_antrian' => $nomor_antrian,
            'status' => 'checked_in',
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'catatan' => $request->catatan,
            'is_preregistered' => false,
            'registered_by' => 'Petugas',
        ]);

        return redirect()->route('petugas.antrian.index')
            ->with('success', 'Kunjungan walk-in berhasil didaftarkan dengan nomor antrian ' . $nomor_antrian);
    }
}
