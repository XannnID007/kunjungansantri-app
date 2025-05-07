<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasional;
use App\Models\Kunjungan;
use App\Models\Santri;
use App\Services\FIFOQueueManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    protected $queueManager;

    public function __construct(FIFOQueueManager $queueManager)
    {
        $this->queueManager = $queueManager;
    }

    public function index()
    {
        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        $kunjungan = Kunjungan::with(['santri'])
            ->where('wali_id', $wali->id)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->paginate(10);

        return view('wali.kunjungan.index', compact('kunjungan'));
    }

    public function create()
    {
        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        $santri_list = $wali->santri;

        if ($santri_list->isEmpty()) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda tidak memiliki santri terdaftar. Silahkan hubungi admin.');
        }

        // Ambil jadwal untuk 1 minggu ke depan
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addDays(7);

        $jadwal_operasional = JadwalOperasional::where('is_active', true)
            ->get();

        $jadwal_tersedia = [];

        // Loop untuk setiap hari dalam seminggu
        for ($date = $start_date; $date <= $end_date; $date->addDay()) {
            $hari = strtolower($date->locale('id')->dayName);
            $tanggal = $date->format('Y-m-d');

            // Cari jadwal yang sesuai dengan hari ini
            $jadwal_hari_ini = $jadwal_operasional->filter(function ($item) use ($hari) {
                return strtolower($item->hari) == $hari;
            });

            if ($jadwal_hari_ini->isNotEmpty()) {
                foreach ($jadwal_hari_ini as $jadwal) {
                    // Hitung slot tersedia
                    $slots = $this->queueManager->getAvailableSlots($tanggal, [$jadwal]);

                    foreach ($slots as $slot) {
                        if ($slot['is_available']) {
                            $jadwal_tersedia[] = [
                                'tanggal' => $tanggal,
                                'hari' => $date->locale('id')->dayName,
                                'jadwal_id' => $slot['jadwal_id'],
                                'jam' => $slot['jam'],
                                'jam_operasional' => $slot['jam_operasional'],
                                'tersedia' => $slot['tersedia'],
                                'kuota' => $slot['kuota'],
                            ];
                        }
                    }
                }
            }
        }

        return view('wali.kunjungan.create', compact('santri_list', 'jadwal_tersedia'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'santri_id' => 'required|exists:santri,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required',
            'tujuan_kunjungan' => 'required|string|max:255',
            'barang.*.nama_barang' => 'nullable|string|max:255',
            'barang.*.jumlah' => 'nullable|integer|min:1',
        ]);

        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        // Generate kode kunjungan
        $kode_kunjungan = 'KJG-' . strtoupper(Str::random(6));

        // Hitung nomor antrian FIFO
        $nomor_antrian = $this->queueManager->generateQueueNumber(
            $request->tanggal_kunjungan,
            $request->jam_kunjungan
        );

        // Buat kunjungan
        $kunjungan = Kunjungan::create([
            'kode_kunjungan' => $kode_kunjungan,
            'wali_id' => $wali->id,
            'santri_id' => $request->santri_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan' => $request->jam_kunjungan,
            'estimasi_durasi' => 30, // Default 30 menit
            'nomor_antrian' => $nomor_antrian,
            'status' => 'confirmed',
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'catatan' => $request->catatan,
            'is_preregistered' => true,
            'registered_by' => 'Sistem',
        ]);

        // Jika ada barang
        if ($request->has('barang')) {
            foreach ($request->barang as $item) {
                if (!empty($item['nama_barang'])) {
                    $kode_barang = 'BRG-' . strtoupper(Str::random(6));

                    $kunjungan->barang()->create([
                        'kode_barang' => $kode_barang,
                        'nama_barang' => $item['nama_barang'],
                        'deskripsi' => $item['deskripsi'] ?? null,
                        'jumlah' => $item['jumlah'] ?? 1,
                        'status' => 'diserahkan',
                        'waktu_diserahkan' => now(),
                    ]);
                }
            }
        }

        // Hitung estimasi waktu tunggu
        $waiting_time = $this->queueManager->calculateWaitingTime(
            $nomor_antrian,
            $request->tanggal_kunjungan,
            $request->jam_kunjungan
        );

        return redirect()->route('wali.kunjungan.show', $kunjungan->id)
            ->with('success', 'Pendaftaran kunjungan berhasil dengan nomor antrian ' . $nomor_antrian . '. Estimasi waktu tunggu: ' . $waiting_time . ' menit');
    }

    public function show($id)
    {
        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        $kunjungan = Kunjungan::with(['santri', 'barang'])
            ->where('wali_id', $wali->id)
            ->findOrFail($id);

        return view('wali.kunjungan.show', compact('kunjungan'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        $kunjungan = Kunjungan::with(['santri', 'barang'])
            ->where('wali_id', $wali->id)
            ->findOrFail($id);

        // Kunjungan hanya bisa diedit jika statusnya pending atau confirmed
        if (!in_array($kunjungan->status, ['pending', 'confirmed'])) {
            return redirect()->route('wali.kunjungan.index')
                ->with('warning', 'Kunjungan tidak dapat diedit karena status: ' . $kunjungan->status);
        }

        $santri_list = $wali->santri;

        return view('wali.kunjungan.edit', compact('kunjungan', 'santri_list'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tujuan_kunjungan' => 'required|string|max:255',
            'barang.*.nama_barang' => 'nullable|string|max:255',
            'barang.*.jumlah' => 'nullable|integer|min:1',
        ]);

        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        $kunjungan = Kunjungan::where('wali_id', $wali->id)->findOrFail($id);

        // Kunjungan hanya bisa diedit jika statusnya pending atau confirmed
        if (!in_array($kunjungan->status, ['pending', 'confirmed'])) {
            return redirect()->route('wali.kunjungan.index')
                ->with('warning', 'Kunjungan tidak dapat diedit karena status: ' . $kunjungan->status);
        }

        $kunjungan->update([
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'catatan' => $request->catatan,
        ]);

        // Update barang yang ada
        if ($request->has('barang_existing')) {
            foreach ($request->barang_existing as $barang_id => $item) {
                $barang = $kunjungan->barang()->find($barang_id);

                if ($barang) {
                    if (!empty($item['nama_barang'])) {
                        $barang->update([
                            'nama_barang' => $item['nama_barang'],
                            'deskripsi' => $item['deskripsi'] ?? null,
                            'jumlah' => $item['jumlah'] ?? 1,
                        ]);
                    } else {
                        $barang->delete();
                    }
                }
            }
        }

        // Tambah barang baru
        if ($request->has('barang')) {
            foreach ($request->barang as $item) {
                if (!empty($item['nama_barang'])) {
                    $kode_barang = 'BRG-' . strtoupper(Str::random(6));

                    $kunjungan->barang()->create([
                        'kode_barang' => $kode_barang,
                        'nama_barang' => $item['nama_barang'],
                        'deskripsi' => $item['deskripsi'] ?? null,
                        'jumlah' => $item['jumlah'] ?? 1,
                        'status' => 'diserahkan',
                        'waktu_diserahkan' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('wali.kunjungan.show', $kunjungan->id)
            ->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $wali = $user->waliSantri;

        if (!$wali) {
            return redirect()->route('wali.dashboard')
                ->with('warning', 'Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin.');
        }

        $kunjungan = Kunjungan::where('wali_id', $wali->id)->findOrFail($id);

        // Kunjungan hanya bisa dibatalkan jika statusnya pending atau confirmed
        if (!in_array($kunjungan->status, ['pending', 'confirmed'])) {
            return redirect()->route('wali.kunjungan.index')
                ->with('warning', 'Kunjungan tidak dapat dibatalkan karena status: ' . $kunjungan->status);
        }

        $kunjungan->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('wali.kunjungan.index')
            ->with('success', 'Kunjungan berhasil dibatalkan.');
    }

    public function jadwalTersedia()
    {
        // Ambil jadwal untuk 1 minggu ke depan
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addDays(7);

        $jadwal_operasional = JadwalOperasional::where('is_active', true)
            ->get();

        $jadwal_tersedia = [];

        // Loop untuk setiap hari dalam seminggu
        for ($date = clone $start_date; $date <= $end_date; $date->addDay()) {
            $hari = strtolower($date->locale('id')->dayName);
            $tanggal = $date->format('Y-m-d');

            // Cari jadwal yang sesuai dengan hari ini
            $jadwal_hari_ini = $jadwal_operasional->filter(function ($item) use ($hari) {
                return strtolower($item->hari) == $hari;
            });

            if ($jadwal_hari_ini->isNotEmpty()) {
                $slots_per_day = [];

                foreach ($jadwal_hari_ini as $jadwal) {
                    // Hitung slot tersedia
                    $slots = $this->queueManager->getAvailableSlots($tanggal, [$jadwal]);

                    foreach ($slots as $slot) {
                        $slots_per_day[] = [
                            'jadwal_id' => $slot['jadwal_id'],
                            'jam' => $slot['jam'],
                            'jam_operasional' => $slot['jam_operasional'],
                            'tersedia' => $slot['tersedia'],
                            'kuota' => $slot['kuota'],
                            'is_available' => $slot['is_available'],
                        ];
                    }
                }

                $jadwal_tersedia[] = [
                    'tanggal' => $tanggal,
                    'hari' => $date->locale('id')->dayName,
                    'slots' => $slots_per_day,
                ];
            }
        }

        return view('wali.kunjungan.jadwal-tersedia', compact('jadwal_tersedia'));
    }
}
