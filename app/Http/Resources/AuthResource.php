<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthResource extends JsonResource
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
            'username' => $this->username,
            'role' => $this->getRoleNames()->first(),
            'status' => $this->status,
            'perangkat_id' => $this->perangkat_id,
            'perangkat_desa' => $this->perangkatDesa ? [
                // 'id' => $this->perangkatDesa->id,
                // 'uuid' => $this->perangkatDesa->uuid,
                'nama_perangkat_desa' => $this->perangkatDesa->penduduk?->nama_lengkap,
                'status_keaktifan' => $this->perangkatDesa->status_keaktifan,
                // 'penduduk_id' => $this->perangkatDesa->penduduk_id,
                // 'jabatan_id' => $this->perangkatDesa->jabatan_id,
                'jabatan' => $this->perangkatDesa->jabatan?->jabatan,
                // 'periode_jabatan_id' => $this->perangkatDesa->periode_jabatan_id,
                // 'periode_jabatan' => $this->perangkatDesa->periode_jabatan?->nama_periode,
                // 'desa_id' => $this->perangkatDesa->desa_id?->,
                // 'dusun_id' => $this->perangkatDesa->dusun_id,
                'dusun' => $this->perangkatDesa->dusun?->nama,
                // 'rt_id' => $this->perangkatDesa->rt_id,
                // 'rw_id' => $this->perangkatDesa->rw_id,
                'nomor_rt' => $this->perangkatDesa->rt?->nomor_rt,
                'nomor_rw' => $this->perangkatDesa->rw?->nomor_rw,
            ] : null,
        ];
    }

}
