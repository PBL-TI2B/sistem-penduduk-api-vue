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
        Schema::create('bantuan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama_bantuan', 50);
            $table->enum('jenis_bantuan', ['tunai', 'pangan', 'pendidikan', 'kesehatan', 'perumahan','lainnya']);
            $table->string('nominal', 50)->nullable();
            $table->string('periode', 50);
            $table->string('lama_periode', 50);
            $table->string('instansi', 50);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bantuan');
    }
};
