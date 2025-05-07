<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function index(Request $request)
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

        // Filter by santri or wali
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('santri', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhereHas('waliSantri', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhere('kode_kunjungan', 'like', "%{$search}%");
            });
        }

        $kunjungan = $query->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->paginate(15);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function create()
    {
        $santri = Santri::where('is_active', true)->orderBy('nama')->get();
        $wali = WaliSantri::orderBy('nama')->get();

        return view('admin.kunjungan.create', compact('santri', 'wali'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'wali_id' => 'required|exists:wali_santri,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required|date_format:H:i',
            'tujuan_kunjungan' => 'required|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,in_progress,completed,cancelled',
        ]);

        // Generate kode kunjungan
        $kode_kunjungan = 'KJG-' . strtoupper(substr(md5(time()), 0, 6));

        // Hitung nomor antrian
        $tanggal = $request->tanggal_kunjungan;
        $jam = $request->jam_kunjungan;

        $lastAntrian = Kunjungan::where('tanggal_kunjungan', $tanggal)
            ->where('jam_kunjungan', $jam)
            ->max('nomor_antrian') ?? 0;

        $nomor_antrian = $lastAntrian + 1;

        // Buat kunjungan
        Kunjungan::create([
            'kode_kunjungan' => $kode_kunjungan,
            'santri_id' => $request->santri_id,
            'wali_id' => $request->wali_id,
            'tanggal_kunjungan' => $tanggal,
            'jam_kunjungan' => $jam,
            'estimasi_durasi' => 30, // Default 30 menit
            'nomor_antrian' => $nomor_antrian,
            'status' => $request->status,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'catatan' => $request->catatan,
            'is_preregistered' => true,
            'registered_by' => 'Admin',
        ]);

        return redirect()->route('admin.kunjungan.index')
            ->with('success', 'Kunjungan berhasil ditambahkan.');
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['santri', 'waliSantri', 'barang']);
        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    public function edit(Kunjungan $kunjungan)
    {
        $santri = Santri::where('is_active', true)->orderBy('nama')->get();
        $wali = WaliSantri::orderBy('nama')->get();
        return view('admin.kunjungan.edit', compact('kunjungan', 'santri', 'wali'));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required|date_format:H:i',
            'tujuan_kunjungan' => 'required|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,in_progress,completed,cancelled',
        ]);

        // Jika tanggal atau jam berubah, perlu hitung ulang nomor antrian
        if (
            $kunjungan->tanggal_kunjungan != $request->tanggal_kunjungan ||
            $kunjungan->jam_kunjungan != $request->jam_kunjungan
        ) {

            $tanggal = $request->tanggal_kunjungan;
            $jam = $request->jam_kunjungan;

            $lastAntrian = Kunjungan::where('tanggal_kunjungan', $tanggal)
                ->where('jam_kunjungan', $jam)
                ->max('nomor_antrian') ?? 0;

            $nomor_antrian = $lastAntrian + 1;

            $kunjungan->nomor_antrian = $nomor_antrian;
        }

        // Update kunjungan
        $kunjungan->update([
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan' => $request->jam_kunjungan,
            'status' => $request->status,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.kunjungan.index')
            ->with('success', 'Kunjungan berhasil diperbarui.');
    }

    public function destroy(Kunjungan $kunjungan)
    {
        // Hapus barang terkait
        $kunjungan->barang()->delete();

        // Hapus kunjungan
        $kunjungan->delete();

        return redirect()->route('admin.kunjungan.index')
            ->with('success', 'Kunjungan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,in_progress,completed,cancelled',
        ]);

        $kunjungan->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status kunjungan berhasil diperbarui.');
    }
}
