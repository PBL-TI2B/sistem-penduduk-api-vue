<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PendidikanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'jenjang' => $this->jenjang,
            'penduduk_count' => $this->penduduk->count(),
        ];
    }
}
