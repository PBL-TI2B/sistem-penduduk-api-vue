<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenerimaBantuanResource extends JsonResource
{
    // $table->id();
    // $table->uuid('uuid')->unique();
    // $table->enum('status', ['aktif', 'selesai', 'ditolak']);
    // $table->date('tanggal_penerimaan');
    // $table->text('keterangan')->nullable();

    // $table->foreignId('kurangMampu_id')->constrained('kurangMampu')->cascadeOnDelete();
    // $table->foreignId('bantuan_id')->constrained('bantuan')->cascadeOnDelete();

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => $this->status,
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
            'keterangan' => $this->keterangan,
            'kurang_mampu_id' => [
                'id' => $this->kurangMampu?->id,
                'nama_penerima' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->nama_lengkap,
                'pendapatan_per_hari' => $this->kurangMampu?->pendapatan_per_hari,
                'pendapatan_per_bulan' => $this->kurangMampu?->pendapatan_per_bulan,
                'jumlah_tanggungan' => $this->kurangMampu?->jumlah_tanggungan,
                'status_validasi' => $this->kurangMampu?->status_validasi,
                'keterangan' => $this->kurangMampu?->keterangan,
            ],
            'bantuan_id' => [
                'id' => $this->bantuan?->id,
                'nama_bantuan' => $this->bantuan?->nama_bantuan,
                'kategori_bantuan' => $this->bantuan?->kategoriBantuan?->kategori,
                'jenis_bantuan' => $this->bantuan?->jenis_bantuan,
                'nominal' => $this->bantuan?->nominal,
                'periode' => $this->bantuan?->periode,
                'lama_periode' => $this->bantuan?->lama_periode,
                'instansi' => $this->bantuan?->instansi,
                'keterangan' => $this->bantuan?->keterangan,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
