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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'judul' => $this->judul,
            'foto' => $this->url_media 
                ? asset('storage/galeri/' . $this->url_media)
                : null,
            'user' => [
                'username' => $this->user?->username
            ],
            'created_at' => $this->created_at,
        ];
    }

}
