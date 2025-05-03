<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GaleriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'uuid' => $this->uuid,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'deskripsi' => $this->deskripsi,
            'tanggal_post' => $this->tanggal_post,
            'url_media' => $this->url_media,
            'user'=> [
                'name' => $this->user?->username
            ],
        ];
    }
}
