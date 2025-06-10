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
            'jumlah_dilihat' => $this->jumlah_dilihat,
            'status' => $this->status,
            'user_id' => [
                'id' => $this->user?->id,
                'username' => $this->user?->username,
            ],
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }

}
