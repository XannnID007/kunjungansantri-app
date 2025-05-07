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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungan')->onDelete('cascade');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('foto')->nullable();
            $table->enum('status', ['diserahkan', 'diterima', 'dikembalikan', 'ditolak'])->default('diserahkan');
            $table->text('alasan_ditolak')->nullable();
            $table->timestamp('waktu_diserahkan')->nullable();
            $table->timestamp('waktu_diterima')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
