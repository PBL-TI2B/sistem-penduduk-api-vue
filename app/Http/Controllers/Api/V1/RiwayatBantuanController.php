<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatBantuan;
use App\Http\Resources\ApiResource;
use App\Http\Resources\RiwayatBantuanResource;
use Illuminate\Support\Facades\Validator;

class RiwayatBantuanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $query = RiwayatBantuan::query();

        // Filter berdasarkan penerima_bantuan_id (wajib)
        if ($request->filled('penerima_bantuan_id')) {
            $query->where('penerima_bantuan_id', $request->penerima_bantuan_id);
        } else {
            return new ApiResource(false, 'Harus mencantumkan id penerima bantuan', []);
        }

        $data = $query->paginate($perPage);
        $collection = RiwayatBantuanResource::collection($data->getCollection());
        $data->setCollection(collect($collection));

        return new ApiResource(true, 'Daftar Data Riwayat Bantuan', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penerima_bantuan_id' => 'required|exists:penerima_bantuan,id',
            'status_pencairan' => 'required|in:diterima,diproses,belum diterima',
            'tanggal' => 'required|date',
            'dokumentasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = RiwayatBantuan::create($validator->validated());

        return new ApiResource(true, 'Data Riwayat Bantuan berhasil ditambahkan', new RiwayatBantuanResource($data));
    }

    public function show(RiwayatBantuan $riwayatBantuan)
    {
        return new ApiResource(true, 'Detail Riwayat Bantuan', new RiwayatBantuanResource($riwayatBantuan));
    }

    public function update(Request $request, RiwayatBantuan $riwayatBantuan)
    {
        $validator = Validator::make($request->all(), [
            'penerima_bantuan_id' => 'sometimes|exists:penerima_bantuan,id',
            'status_pencairan' => 'sometimes|in:diterima,diproses,belum diterima',
            'tanggal' => 'sometimes|date',
            'dokumentasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $riwayatBantuan->update($validator->validated());

        return new ApiResource(true, 'Data Riwayat Bantuan berhasil diperbarui', new RiwayatBantuanResource($riwayatBantuan));
    }

    public function destroy(RiwayatBantuan $riwayatBantuan)
    {
        $riwayatBantuan->delete();

        return new ApiResource(true, 'Data Riwayat Bantuan berhasil dihapus', null);
    }
}