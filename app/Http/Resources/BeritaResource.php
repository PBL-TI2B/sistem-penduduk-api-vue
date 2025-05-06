<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'konten' => $this->konten,
            'tanggal_post' => $this->tanggal_post,
            'jumlah_dilihat' => $this->jumlah_dilihat,
            'status' => $this->status,
            'user_id' => [
                'id' => $this->user?->id,
                'name' => $this->user?->username,
            ],
        ];
    }

}
