<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BantuanResource extends JsonResource
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
            'nama_bantuan'        => $this->nama_bantuan,
            'kategori_id'         => $this->kategori_bantuan_id,
            'kategori_uuid'       => $this->kategoriBantuan->uuid,
            // 'kategori'            => ucfirst($this->kategoriBantuan->kategori),
            'kategori'            => $this->kategoriBantuan->kategori,
            'nominal'             => $this->nominal,
            'status'              => $this->status,
            'periode'             => $this->periode,
            'lama_periode'        => $this->lama_periode,
            'instansi'            => $this->instansi,
            'keterangan'          => $this->keterangan,
            'penerima_bantuan_count'       => $this->penerima_bantuan_count,
            // 'penerimaBantuan'       => $this->penerimaBantuan,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}