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
        Schema::create('wali_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama');
            $table->string('no_identitas')->unique(); // KTP/SIM
            $table->string('no_hp')->nullable();
            $table->boolean('has_smartphone')->default(false);
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->string('hubungan'); // Ayah, Ibu, Wali, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_santris');
    }
};
