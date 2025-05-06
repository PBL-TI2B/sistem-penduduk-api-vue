<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PindahanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'penduduk_id' => [
                'nama_lengkap' => $this->penduduk->nama_lengkap,
            ],
            'status_pindahan' => $this->status_pindahan,
            'tanggal_pindahan' => $this->tanggal_pindahan,
            'alamat_asal_tujuan' => $this->alamat_asal_tujuan,

        ];
    }
}
//