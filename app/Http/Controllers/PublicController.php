<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicController extends Controller
{
    public function displayAntrian()
    {
        $today = Carbon::now()->format('Y-m-d');

        $current_kunjungan = Kunjungan::with(['santri', 'waliSantri'])
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'in_progress')
            ->get();

        $next_kunjungan = Kunjungan::with(['santri', 'waliSantri'])
            ->where('tanggal_kunjungan', $today)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->orderBy('jam_kunjungan', 'asc')
            ->orderBy('nomor_antrian', 'asc')
            ->limit(5)
            ->get();

        return view('public.display-antrian', compact('current_kunjungan', 'next_kunjungan'));
    }

    public function checkAntrian($kode)
    {
        $kunjungan = Kunjungan::with(['santri', 'waliSantri', 'barang'])
            ->where('kode_kunjungan', $kode)
            ->first();

        if (!$kunjungan) {
            return redirect()->back()->with('error', 'Kode kunjungan tidak ditemukan.');
        }

        // Hitung estimasi waktu tunggu
        $estimasi_tunggu = 0;

        if (in_array($kunjungan->status, ['pending', 'confirmed', 'checked_in'])) {
            $kunjungan_sebelumnya = Kunjungan::where('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('jam_kunjungan', $kunjungan->jam_kunjungan)
                ->where('nomor_antrian', '<', $kunjungan->nomor_antrian)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->get();

            foreach ($kunjungan_sebelumnya as $k) {
                $estimasi_tunggu += $k->estimasi_durasi;
            }
        }

        return view('public.check-antrian', compact('kunjungan', 'estimasi_tunggu'));
    }
}
