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
        Schema::create('kelahiran', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('anak_ke', 50);
            $table->string('berat', 50)->nullable();
            $table->string('panjang', 50)->nullable();
            $table->datetime('waktu_kelahiran')->nullable();
            $table->string('lokasi', 50)->nullable();
            $table->text('keterangan')->nullable();

            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelahiran');
    }
};
