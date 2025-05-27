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
        Schema::create('penerima_bantuan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('status', ['aktif', 'selesai', 'ditolak']);
            $table->date('tanggal_penerimaan');
            $table->text('keterangan')->nullable();

            $table->foreignId('kurang_mampu_id')->constrained('kurang_mampu')->cascadeOnDelete();
            $table->foreignId('bantuan_id')->constrained('bantuan')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuan');
    }
};
