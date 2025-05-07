<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kunjungan')->unique();
            $table->foreignId('wali_id')->constrained('wali_santri');
            $table->foreignId('santri_id')->constrained('santri');
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan')->nullable(); // Jam yang dipilih
            $table->timestamp('waktu_kedatangan')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->integer('estimasi_durasi')->default(30); // dalam menit
            $table->integer('nomor_antrian')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('tujuan_kunjungan')->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('is_preregistered')->default(false); // Mendaftar sebelumnya atau langsung datang
            $table->string('registered_by')->nullable(); // Sistem atau Petugas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
