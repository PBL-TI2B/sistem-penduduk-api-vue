<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotifikasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'aksi_user' => [
                'id' => $this->aksi_user_id,
                'username' => $this->user?->username, 
            ],
            'jenis' => $this->jenis,
            'deskripsi' => $this->deskripsi,
            'waktu_aksi' => $this->waktu_aksi->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
