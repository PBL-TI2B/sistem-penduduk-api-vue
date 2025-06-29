<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatBantuanResource extends JsonResource
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
            'penerima_bantuan_id' => $this->penerima_bantuan_id,
            'status' => $this->status,
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
            // 'dokumentasi' => $this->dokumentasi,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relasi ke penerima bantuan
            'penerima_bantuan' => new PenerimaBantuanResource($this->whenLoaded('penerimaBantuan')),
        ];
    }
}