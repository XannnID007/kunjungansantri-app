<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with(['kunjungan.santri', 'kunjungan.waliSantri'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('petugas.barang.index', compact('barang'));
    }

    public function show($id)
    {
        $barang = Barang::with(['kunjungan.santri', 'kunjungan.waliSantri'])->findOrFail($id);
        return view('petugas.barang.show', compact('barang'));
    }

    public function scanBarang(Request $request)
    {
        $kode_barang = $request->kode_barang;

        $barang = Barang::where('kode_barang', $kode_barang)->first();

        if (!$barang) {
            return redirect()->back()->with('error', 'Barang dengan kode tersebut tidak ditemukan.');
        }

        return redirect()->route('petugas.barang.show', $barang->id);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diserahkan,diterima,dikembalikan,ditolak',
            'alasan_ditolak' => 'required_if:status,ditolak',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $barang = Barang::findOrFail($id);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/barang', $filename);

            $barang->foto = $filename;
        }

        // Update status
        $barang->status = $request->status;

        if ($request->status == 'ditolak') {
            $barang->alasan_ditolak = $request->alasan_ditolak;
        }

        if ($request->status == 'diterima') {
            $barang->waktu_diterima = now();
        }

        $barang->save();

        return redirect()->route('petugas.barang.show', $barang->id)
            ->with('success', 'Status barang berhasil diperbarui.');
    }

    public function labelBarang($id)
    {
        $barang = Barang::with(['kunjungan.santri', 'kunjungan.waliSantri'])->findOrFail($id);
        return view('petugas.barang.label', compact('barang'));
    }

    public function cetakLabel($id)
    {
        $barang = Barang::with(['kunjungan.santri', 'kunjungan.waliSantri'])->findOrFail($id);
        return view('petugas.barang.cetak-label', compact('barang'));
    }
}
