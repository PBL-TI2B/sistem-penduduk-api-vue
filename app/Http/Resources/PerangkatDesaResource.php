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
            'penduduk' =>[ 
                'id'=> $this->penduduk?->id,
                'nama_lengkap' => $this->penduduk?->nama_lengkap
            ],
            'foto'=> $this->penduduk?->foto,
            'jabatan' => [
            'id'=> $this->jabatan?->id,
                'jabatan'=> $this->jabatan?->jabatan
            ],
            'desa' => [
                'id'=> $this->desa?->id,
                'nama'=>$this->desa?->nama
            ],
            'dusun' => [
                'id'=> $this->dusun?->id,
                'nama'=>$this->dusun?->nama
            ]
            ,
            'rw' => [
                'id'=> $this->rw?->id,
                'nomor_rw'=>$this->rw?->nomor_rw
            ],
            'rt' => [
                'id'=> $this->rt?->id,
                'nomor_rt'=>$this->rt?->nomor_rt
            ],
            'status_keaktifan' => $this->status_keaktifan,
            'periode_jabatan' => [
                'id'=> $this->periode_jabatan?->id,
                'awal_menjabat' => $this->periode_jabatan?->awal_menjabat,
                'akhir_menjabat' => $this->periode_jabatan?->akhir_menjabat,
            ],
        ];
    }
}