<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DusunResource extends JsonResource
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
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'lokasi' => $this->lokasi,
            'desa' => $this->desa->nama,
        ];
    }
}
