<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KurangMampuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            //! Tabel KurangMampu
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status_validasi' => $this->status_validasi,
            // 'status_validasi' => ucfirst($this->status_validasi),
            'pendapatan_per_hari' => $this->pendapatan_per_hari,
            'pendapatan_per_bulan' => $this->pendapatan_per_bulan,
            'jumlah_tanggungan' => $this->jumlah_tanggungan,
            'keterangan' => $this->keterangan,

            //! Tabel Penduduk
            // 'penduduk' => new PendudukResource(
            //     $this->anggotaKeluarga->penduduk
            // ),
            // 'penduduk' => $this->anggotaKeluarga->penduduk,
            'penduduk' => [ // 'uuid_penduduk' => $this->anggotaKeluarga?->penduduk?->uuid,
                'nik' => $this->anggotaKeluarga?->penduduk?->nik,
                'nama_lengkap' => $this->anggotaKeluarga?->penduduk?->nama_lengkap,
                'foto' => $this->anggotaKeluarga?->penduduk?->foto,
                'jenis_kelamin' => $this->anggotaKeluarga?->penduduk?->jenis_kelamin,
                // 'status_perkawinan' => ucfirst($this->anggotaKeluarga?->penduduk?->status_perkawinan),
                'tempat_lahir' => $this->anggotaKeluarga?->penduduk?->tempat_lahir,
                'tanggal_lahir' => $this->anggotaKeluarga?->penduduk?->tanggal_lahir,
                'agama' => $this->anggotaKeluarga?->penduduk?->agama,
                'gol_darah' => $this->anggotaKeluarga?->penduduk?->gol_darah,
                'status_perkawinan' => $this->anggotaKeluarga?->penduduk?->status_perkawinan,

                //! Tabel Pekerjaan
                'pekerjaan' => $this->anggotaKeluarga?->penduduk?->pekerjaan?->nama_pekerjaan,
                //! Tabel Pendidikan
                'pendidikan' => $this->anggotaKeluarga?->penduduk?->pendidikan?->jenjang,
                //! Tabel Kartu Keluarga
                // 'id_kk' => $this->anggotaKeluarga?->kk?->id,
                // 'uuid_kk' => $this->anggotaKeluarga?->kk?->uuid,
                'no_kk' => $this->anggotaKeluarga?->kk->nomor_kk,
                //! Tabel StatusKeluarga
                'status_keluarga' => $this->anggotaKeluarga?->statusKeluarga?->status_keluarga,
                //! Tabel RT
                'nomor_rt' => $this->anggotaKeluarga?->penduduk->domisili->rt?->nomor_rt,
                //! Tabel RW
                'nomor_rw' => $this->anggotaKeluarga?->penduduk->domisili->rt?->rw?->nomor_rw,
                //! Tabel Dusun
                'nama_dusun' => $this->anggotaKeluarga?->penduduk->domisili->rt?->rw?->dusun?->nama,
            ],

            'penerima_bantuan_count' => $this->penerima_bantuan_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}