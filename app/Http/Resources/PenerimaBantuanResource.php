<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenerimaBantuanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => ucfirst($this->status),
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
            'keterangan' => $this->keterangan,

            'kurang_mampu' => new KurangMampuResource($this->whenLoaded('kurangMampu')),
            // 'uuid_kurang_mampu' => $this->kurangMampu?->uuid,
            // 'status_validasi' => $this->kurangMampu?->status_validasi,
            // 'pendapatan_per_hari' => $this->kurangMampu?->pendapatan_per_hari,
            // 'pendapatan_per_bulan' => $this->kurangMampu?->pendapatan_per_bulan,
            // 'jumlah_tanggungan' => $this->kurangMampu?->jumlah_tanggungan,
            // 'keterangan' => $this->keterangan,
            // 'uuid_penduduk' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->uuid,
            // 'nik' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->nik,
            // 'nama_lengkap' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->nama_lengkap,
            // 'status_perkawinan' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->status_perkawinan,
            // 'jenis_kelamin' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->jenis_kelamin,
            // 'pekerjaan' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->pekerjaan?->nama_pekerjaan,
            // 'pendidikan_terakhir' => $this->kurangMampu?->anggotaKeluarga?->penduduk?->pendidikan?->jenjang,
            // 'uuid_kk' => $this->kurangMampu?->anggotaKeluarga?->kk?->uuid,
            // 'no_kk' => $this->kurangMampu?->anggotaKeluarga?->kk?->nomor_kk,
            // 'status_keluarga' => $this->kurangMampu?->anggotaKeluarga?->statusKeluarga?->status_keluarga,
            // 'nomor_rt' => $this->kurangMampu?->anggotaKeluarga?->kk?->rt?->nomor_rt,
            // 'nomor_rw' => $this->kurangMampu?->anggotaKeluarga?->kk?->rt?->rw?->nomor_rw,
            // 'nama_dusun' => $this->kurangMampu?->anggotaKeluarga?->kk?->rt?->rw?->dusun?->nama,

            'bantuan' => new BantuanResource($this->whenLoaded('bantuan')),
            // 'uuid_bantuan'        => $this->bantuan?->uuid,
            // 'nama_bantuan'        => $this->bantuan?->nama_bantuan,
            // 'kategori_id'         => $this->bantuan?->kategori_bantuan_id,
            // 'kategori_uuid'       => $this->bantuan?->kategoriBantuan->uuid,
            // 'kategori'            => ucfirst($this->bantuan?->kategoriBantuan->kategori),
            // 'nominal'             => $this->bantuan?->nominal,
            // 'periode'             => $this->bantuan?->periode,
            // 'lama_periode'        => $this->bantuan?->lama_periode,
            // 'instansi'            => $this->bantuan?->instansi,
            // 'keterangan'          => $this->bantuan?->keterangan,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
