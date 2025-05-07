<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasional;
use Illuminate\Http\Request;

class JadwalOperasionalController extends Controller
{
    public function index()
    {
        $jadwal = JadwalOperasional::orderBy('hari')->orderBy('jam_buka')->get()->groupBy('hari');
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('admin.jadwal.index', compact('jadwal', 'hari'));
    }

    public function create()
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.jadwal.create', compact('hari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
            'kuota_kunjungan' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        JadwalOperasional::create([
            'hari' => $request->hari,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'kuota_kunjungan' => $request->kuota_kunjungan,
            'is_active' => true,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal operasional berhasil ditambahkan.');
    }

    public function edit(JadwalOperasional $jadwal)
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.jadwal.edit', compact('jadwal', 'hari'));
    }

    public function update(Request $request, JadwalOperasional $jadwal)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
            'kuota_kunjungan' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'catatan' => 'nullable|string',
        ]);

        $jadwal->update([
            'hari' => $request->hari,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'kuota_kunjungan' => $request->kuota_kunjungan,
            'is_active' => $request->is_active,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal operasional berhasil diperbarui.');
    }

    public function destroy(JadwalOperasional $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal operasional berhasil dihapus.');
    }

    public function toggleStatus(JadwalOperasional $jadwal)
    {
        $jadwal->update([
            'is_active' => !$jadwal->is_active,
        ]);

        $status = $jadwal->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.jadwal.index')
            ->with('success', "Jadwal operasional berhasil {$status}.");
    }
}
