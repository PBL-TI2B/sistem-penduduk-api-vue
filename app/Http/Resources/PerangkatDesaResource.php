<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerangkatDesaResource extends JsonResource
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
            'nama_lengkap' => $this->penduduk?->nama_lengkap,
            'jabatan' => $this->jabatan?->jabatan,
            'desa' => $this->desa?->nama,
            'dusun' => $this->dusun?->nama,
            'rw' => $this->rw?->nomor_rw,
            'rt' => $this->rt?->nomor_rt,
            'status_keaktifan' => $this->status_keaktifan,
            'periode_jabatan' => [
                'id'=> $this->periode_jabatan?->id,
                'awal_menjabat' => $this->periode_jabatan?->awal_menjabat,
                'akhir_menjabat' => $this->periode_jabatan?->akhir_menjabat,
            ],
        ];
    }
}