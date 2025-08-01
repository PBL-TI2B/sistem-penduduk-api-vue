<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PendudukResource extends JsonResource
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
             'nik' => $this->nik,
             'nama_lengkap' => $this->nama_lengkap,
             'foto' => $this->foto,  // Ini sudah benar untuk accessor foto
             'jenis_kelamin' => $this->jenis_kelamin,
             'tempat_lahir' => $this->tempat_lahir,
             'tanggal_lahir' => $this->tanggal_lahir,
             'agama' => $this->agama,
             'gol_darah' => $this->gol_darah,
             'status_perkawinan' => $this->status_perkawinan,
             'tinggi_badan' => $this->tinggi_badan,
             'status' => $this->status,
     
             'pekerjaan' => [
                 'id' => $this->pekerjaan?->id,
                 'uuid' => $this->pekerjaan?->uuid,
                 'nama_pekerjaan' => $this->pekerjaan?->nama_pekerjaan,
             ],
             'pendidikan' => [
                 'id' => $this->pendidikan?->id,
                 'uuid' => $this->pendidikan?->uuid, // Perbaiki kesalahan penulisan
                 'jenjang' => $this->pendidikan?->jenjang,
             ],
             'domisili' => [
                 'uuid' => $this->domisili?->uuid,
                 'id' => $this->domisili?->id,
                 'status_tempat_tinggal' => $this->domisili?->status_tempat_tinggal,
                 'rt_id' => $this->domisili?->rt?->id,
                 'rt' => $this->domisili?->rt?->nomor_rt,
                 'rw' => $this->domisili?->rt?->rw?->nomor_rw,
                'alamat_asal' => $this->domisili?->alamat_asal,
                'alamat_saat_ini' => $this->domisili?->alamat_saat_ini,
             ],
            
             'ayah' => $this->ayah ? [
            'id' => $this->ayah->id,
            'uuid' => $this->ayah->uuid,
            'nama_lengkap' => $this->ayah->nama_lengkap,
            ] : null,

            'ibu' => $this->ibu ? [
                'id' => $this->ibu->id,
                'uuid' => $this->ibu->uuid,
                'nama_lengkap' => $this->ibu->nama_lengkap,
            ] : null,

         ];
     }
     
}
