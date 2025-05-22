<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KematianResource extends JsonResource
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
            'tanggal_kematian' => $this->tanggal_kematian,
            'sebab_kematian' => $this->sebab_kematian,

            'penduduk' => $this->whenLoaded('penduduk', function () {
                return [
                    'id' => $this->penduduk?->id,
                    'uuid' => $this->penduduk?->uuid,
                    'nik' => $this->penduduk?->nik,
                    'nama_lengkap' => $this->penduduk?->nama_lengkap,
                ];
            }),
        ];
    }
}
