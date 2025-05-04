<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PendudukResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'nik' => $this->nik,
            'nama_lengkap' => $this->nama_lengkap,
            'foto' => $this->foto,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'agama' => $this->agama,
            'gol_darah' => $this->gol_darah,
            'status_perkawinan' => $this->status_perkawinan,
            'tinggi_badan' => $this->tinggi_badan,
            'status' => $this->status,

            'pekerjaan' => [
                'nama_pekerjaan' => $this->pekerjaan?->nama_pekerjaan,
            ],
            'pendidikan' => [
                'jenjang' => $this->pendidikan?->jenjang,
            ],
            'domisili' => [
                'status_tempat_tinggal' => $this->domisili?->status_tempat_tinggal,
                'rt' => $this->domisili?->rt?->nomor_rt,
                'rw' => $this->domisili?->rt?->rw?->nomor_rw,
            ],
        ];
    }
}
