<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\KartuKeluarga;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        // Mengambil daftar Kartu Keluarga dengan paginasi
        $data = KartuKeluarga::paginate(5);
        return new ApiResource(true, 'Daftar Kartu Keluarga', $data);
    }

    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nomor_kk' => 'required|unique:kartu_keluarga,nomor_kk|max:50',
            'rt_id' => 'required',
            'kode_pos' => 'required|max:50',
            'kelurahan' => 'required|max:50',
            'kecamatan' => 'required|max:50',
            'kabupaten' => 'required|max:50',
            'provinsi' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Menyimpan data Kartu Keluarga baru
        $data = KartuKeluarga::create([
            'uuid' => (string) Str::uuid(),
            'nomor_kk' => $request->nomor_kk,
            'rt_id' => $request->rt_id,
            'kode_pos' => $request->kode_pos,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
        ]);

        return new ApiResource(true, 'Kartu Keluarga Berhasil Ditambahkan', $data);
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        // Menampilkan detail Kartu Keluarga
        return new ApiResource(true, 'Detail Kartu Keluarga', $kartuKeluarga);
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        // Validasi data yang diperbarui
        $validator = Validator::make($request->all(), [
            'nomor_kk' => 'required|max:50|unique:kartu_keluarga,nomor_kk,' . $kartuKeluarga->uuid,
            'rt_id' => 'required',
            'kode_pos' => 'required|max:50',
            'kelurahan' => 'required|max:50',
            'kecamatan' => 'required|max:50',
            'kabupaten' => 'required|max:50',
            'provinsi' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update data Kartu Keluarga
        $kartuKeluarga->update($request->only([
            'nomor_kk',
            'rt_id',
            'kode_pos',
            'kelurahan',
            'kecamatan',
            'kabupaten',
            'provinsi'
        ]));

        return new ApiResource(true, 'Kartu Keluarga Berhasil Diperbarui', $kartuKeluarga);
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        // Hapus data Kartu Keluarga
        $kartuKeluarga->delete();
        return new ApiResource(true, 'Kartu Keluarga Berhasil Dihapus', null);
    }
}
