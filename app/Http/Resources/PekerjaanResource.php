<!--<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PekerjaanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'uuid'                => $this->uuid,
            'nama_pekerjaan'        => $this->nama_pekerjaan,
            'pekerjaan_count'       => $this->pekerjaan_count,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}