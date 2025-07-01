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
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('status_keaktifan', ['aktif', 'nonaktif']);

            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->foreignId('jabatan_id')->constrained('jabatan')->onDelete('cascade');
            $table->foreignId('periode_jabatan_id')->constrained('periode_jabatan')->onDelete('cascade');

            //! Relasi Wilayah Jabatan, hanya boleh mengisi salah satu
            $table->foreignId('desa_id')->nullable()->constrained('desa')->onDelete('cascade');
            $table->foreignId('dusun_id')->nullable()->constrained('dusun')->onDelete('cascade');
            $table->foreignId('rt_id')->nullable()->constrained('rt')->onDelete('cascade');
            $table->foreignId('rw_id')->nullable()->constrained('rw')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkat_desa');
    }
};