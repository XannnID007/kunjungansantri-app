<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Santri;
use App\Models\WaliSantri;
use App\Models\Barang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['santri', 'waliSantri']);

        // Filter by date
        if ($request->has('tanggal')) {
            $tanggal = $request->tanggal;
            $query->where('tanggal_kunjungan', $tanggal);
        } else {
            // Default tampilkan data hari ini
            $query->where('tanggal_kunjungan', Carbon::today());
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_kunjungan', 'like', "%{$search}%")
                    ->orWhereHas('santri', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('waliSantri', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        $kunjungan = $query->orderBy('jam_kunjungan')
            ->orderBy('nomor_antrian')
            ->paginate(15);

        return view('petugas.kunjungan.index', compact('kunjungan'));
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['santri', 'waliSantri', 'barang']);
        return view('petugas.kunjungan.show', compact('kunjungan'));
    }

    public function edit(Kunjungan $kunjungan)
    {
        return view('petugas.kunjungan.edit', compact('kunjungan'));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'tujuan_kunjungan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $kunjungan->update([
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('petugas.kunjungan.show', $kunjungan)
            ->with('success', 'Kunjungan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,in_progress,completed,cancelled',
        ]);

        $kunjungan->update([
            'status' => $request->status,
        ]);

        if ($request->status == 'checked_in') {
            $kunjungan->update([
                'waktu_kedatangan' => Carbon::now(),
            ]);
        } elseif ($request->status == 'completed') {
            $kunjungan->update([
                'waktu_selesai' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Status kunjungan berhasil diperbarui.');
    }

    public function addBarang(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        // Generate kode barang
        $kode_barang = 'BRG-' . strtoupper(Str::random(6));

        $barang = Barang::create([
            'kunjungan_id' => $kunjungan->id,
            'kode_barang' => $kode_barang,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'status' => 'diserahkan',
            'waktu_diserahkan' => Carbon::now(),
        ]);

        return redirect()->route('petugas.kunjungan.show', $kunjungan)
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function history()
    {
        $kunjungan = Kunjungan::with(['santri', 'waliSantri'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->paginate(15);

        return view('petugas.kunjungan.history', compact('kunjungan'));
    }
}
