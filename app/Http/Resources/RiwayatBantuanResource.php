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
            'penerima_bantuan_id' => $this->penerima_bantuan_id,
            'status_pencairan' => $this->status_pencairan,
            'tanggal' => $this->tanggal,
            'dokumentasi' => $this->dokumentasi,
            'keterangan' => $this->keterangan,

            // Relasi ke penerima bantuan
            'penerima_bantuan' => new PenerimaBantuanResource($this->whenLoaded('penerimaBantuan')),
        ];
    }
}