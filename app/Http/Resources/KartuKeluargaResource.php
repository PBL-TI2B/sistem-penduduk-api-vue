<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class KartuKeluargaResource extends JsonResource
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
            'nomor_kk' => $this->nomor_kk,
            'rt' => [
                'id' => $this->rt?->id,
                'nomor_rt' => $this->rt?->nomor_rt,
                'nomor_rw' => $this->rt?->rw->nomor_rw,
            ],
            'kode_pos' => $this->kode_pos,
            'kelurahan' => $this->kelurahan,
            'kecamatan' => $this->kecamatan,
            'kabupaten' => $this->kabupaten,
            'provinsi' => $this->provinsi,
            'anggota_keluarga' => $this->anggotaKeluarga->map(function ($anggota) {
                return [
                    'uuid' => $anggota->uuid,
                    'nama_lengkap' => $anggota->penduduk?->nama_lengkap,
                    'nik' => $anggota->penduduk?->nik,
                    'status_keluarga' => $anggota->statusKeluarga?->status_keluarga,
                    'jenis_kelamin' => $anggota->penduduk?->jenis_kelamin,
                    'tanggal_lahir' => $anggota->penduduk?->tanggal_lahir,
                    'pendidikan' => $anggota->penduduk?->pendidikan?->jenjang,
                ];
            }),
        ];
    }
}
