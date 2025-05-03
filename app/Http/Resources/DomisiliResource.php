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
            'uuid' => $this->uuid,
            'penduduk_id' => [
                'nama_lengkap' => $this->penduduk->nama_lengkap,
            ],
            'status_tempat_tinggal' => $this->status_tempat_tinggal,
            'rt_id' => [
                'nomor' => $this->rt->nomor,
                'rw' => [
                    'nomor' => $this->rt->rw->nomor,
                ],
            ],

        ];

    }
}
