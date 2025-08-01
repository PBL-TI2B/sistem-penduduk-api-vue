<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'user' => [
                'id' => $this->user?->id,
                'username' => $this->user?->username,
            ],
            'created_at'   => $this->created_at ? Carbon::parse($this->created_at)->toIso8601String() : null,
            'updated_at'   => $this->updated_at ? Carbon::parse($this->updated_at)->toIso8601String() : null,
            'published_at' => $this->published_at ? Carbon::parse($this->published_at)->toIso8601String() : null,
        ];
    }

}
