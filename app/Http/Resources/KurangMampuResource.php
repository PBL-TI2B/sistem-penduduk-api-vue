<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KurangMampuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status_validasi' => $this->status_validasi,
            'pendapatan_per_hari' => $this->pendapatan_per_hari,
            'pendapatan_per_bulan' => $this->pendapatan_per_bulan,
            'jumlah_tanggungan' => $this->jumlah_tanggungan,
            'keterangan' => $this->keterangan,

            'nik' => $this->anggotaKeluarga?->penduduk?->nik,
            'nama_lengkap' => $this->anggotaKeluarga?->penduduk?->nama_lengkap,
            'status_perkawinan' => $this->anggotaKeluarga?->penduduk?->status_perkawinan,
            'jenis_kelamin' => $this->anggotaKeluarga?->penduduk?->jenis_kelamin,
            'pekerjaan' => $this->anggotaKeluarga?->penduduk?->pekerjaan?->nama_pekerjaan,
            'pendidikan_terakhir' => $this->anggotaKeluarga?->penduduk?->pendidikan?->jenjang,
            'foto' => $this->anggotaKeluarga?->penduduk?->foto,
            'tempat_lahir' => $this->anggotaKeluarga?->penduduk?->tempat_lahir,
            'tanggal_lahir' => $this->anggotaKeluarga?->penduduk?->tanggal_lahir,
            'agama' => $this->anggotaKeluarga?->penduduk?->agama,
            'gol_darah' => $this->anggotaKeluarga?->penduduk?->gol_darah,

            'no_kk' => $this->anggotaKeluarga?->kk?->nomor_kk,

            'status_keluarga' => $this->anggotaKeluarga?->statusKeluarga?->status_keluarga,

            'nomor_rt' => $this->anggotaKeluarga?->kk?->rt?->nomor_rt,

            'nomor_rw' => $this->anggotaKeluarga?->kk?->rt?->rw?->nomor_rw,

            'nama_dusun' => $this->anggotaKeluarga?->kk?->rt?->rw?->dusun?->nama,


            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
