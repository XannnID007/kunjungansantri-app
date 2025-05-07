<?php

namespace App\Services;

use App\Models\Kunjungan;
use App\Models\Notifikasi;
use Carbon\Carbon;

class FIFOQueueManager
{
     /**
      * Generate nomor antrian berdasarkan tanggal dan jam kunjungan
      */
     public function generateQueueNumber($tanggal, $jamKunjungan)
     {
          $lastQueue = Kunjungan::where('tanggal_kunjungan', $tanggal)
               ->where('jam_kunjungan', $jamKunjungan)
               ->max('nomor_antrian') ?? 0;

          return $lastQueue + 1;
     }

     /**
      * Menghitung estimasi waktu tunggu untuk sebuah antrian
      */
     public function calculateWaitingTime($nomorAntrian, $tanggal, $jamKunjungan)
     {
          // Ambil semua kunjungan yang sudah terdaftar pada slot waktu yang sama
          $queuedVisits = Kunjungan::where('tanggal_kunjungan', $tanggal)
               ->where('jam_kunjungan', $jamKunjungan)
               ->where('nomor_antrian', '<', $nomorAntrian)
               ->whereNotIn('status', ['cancelled', 'completed'])
               ->get();

          // Hitung total waktu tunggu berdasarkan durasi rata-rata
          $totalWaitingTime = 0;
          foreach ($queuedVisits as $visit) {
               $totalWaitingTime += $visit->estimasi_durasi;
          }

          return $totalWaitingTime;
     }

     /**
      * Mendapatkan kunjungan berikutnya berdasarkan FIFO
      */
     public function getNextVisit($tanggal, $jamKunjungan)
     {
          return Kunjungan::where('tanggal_kunjungan', $tanggal)
               ->where('jam_kunjungan', $jamKunjungan)
               ->whereIn('status', ['confirmed', 'pending'])
               ->orderBy('nomor_antrian', 'asc')
               ->first();
     }

     /**
      * Memproses kunjungan berikutnya
      */
     public function processNextVisit($tanggal, $jamKunjungan)
     {
          $nextVisit = $this->getNextVisit($tanggal, $jamKunjungan);

          if ($nextVisit) {
               $nextVisit->update([
                    'status' => 'in_progress',
                    'waktu_kedatangan' => now()
               ]);

               // Kirim notifikasi
               $this->sendNotification($nextVisit);

               return $nextVisit;
          }

          return null;
     }

     /**
      * Kirim notifikasi untuk kunjungan
      */
     protected function sendNotification($kunjungan)
     {
          // Cek apakah wali santri memiliki smartphone
          $waliSantri = $kunjungan->waliSantri;
          $santri = $kunjungan->santri;

          if ($waliSantri->has_smartphone && $waliSantri->user_id) {
               // Kirim notifikasi web
               Notifikasi::create([
                    'user_id' => $waliSantri->user_id,
                    'judul' => 'Giliran Kunjungan Anda',
                    'pesan' => "Nomor antrian {$kunjungan->nomor_antrian} untuk mengunjungi santri {$santri->nama} siap untuk kunjungan",
                    'jenis' => 'Sistem',
                    'waktu_kirim' => now()
               ]);
          } else if ($waliSantri->no_hp) {
               // Simulasi kirim SMS
               logger()->info("SMS to {$waliSantri->no_hp}: Nomor antrian {$kunjungan->nomor_antrian} untuk santri {$santri->nama} siap untuk kunjungan");
          }

          // Log untuk tampilan di papan informasi
          logger()->info("DISPLAY: Nomor antrian {$kunjungan->nomor_antrian} - {$waliSantri->nama} untuk santri {$santri->nama}");
     }

     /**
      * Mendapatkan jadwal tersedia
      */
     public function getAvailableSlots($tanggal, $jadwalOperasional)
     {
          $slots = [];

          foreach ($jadwalOperasional as $jadwal) {
               // Hitung jadwal yang sudah terisi
               $bookedCount = Kunjungan::where('tanggal_kunjungan', $tanggal)
                    ->where('jam_kunjungan', $jadwal->jam_buka)
                    ->whereNotIn('status', ['cancelled'])
                    ->count();

               // Cek apakah kuota masih tersedia
               $isAvailable = $bookedCount < $jadwal->kuota_kunjungan;

               $slots[] = [
                    'jadwal_id' => $jadwal->id,
                    'hari' => $jadwal->hari,
                    'jam' => $jadwal->jam_buka,
                    'jam_operasional' => $jadwal->jam_operasional,
                    'kuota' => $jadwal->kuota_kunjungan,
                    'tersedia' => $jadwal->kuota_kunjungan - $bookedCount,
                    'is_available' => $isAvailable,
               ];
          }

          return $slots;
     }
}
