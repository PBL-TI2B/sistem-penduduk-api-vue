<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DomisiliResource extends JsonResource
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
            'penduduk' => [
                'id' => $this->penduduk->id,
                'nama_lengkap' => $this->penduduk->nama_lengkap,
            ],
            'status_tempat_tinggal' => $this->status_tempat_tinggal,
            'rt' => [
                'id' => $this->rt->id,
                'nomor' => $this->rt->nomor_rt,
                'rw' => [
                    'id' => $this->rt->rw->id,
                    'nomor' => $this->rt->rw->nomor_rw,
                ],
            ],
        ];
    }
    
}
