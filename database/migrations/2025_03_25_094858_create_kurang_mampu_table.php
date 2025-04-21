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
        Schema::create('kurang_mampu', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('pendapatan_per_hari', 50)->nullable();
            $table->string('pendapatan_per_bulan', 50)->nullable();
            $table->string('jumlah_tanggungan', 50)->nullable();
            $table->enum('status_validasi', ['pending', 'terverifikasi', 'ditolak'])->default('pending');
            $table->text('keterangan')->nullable();

            $table->foreignId('anggota_keluarga_id')->constrained('anggota_keluarga')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurang_mampu');
    }
};
