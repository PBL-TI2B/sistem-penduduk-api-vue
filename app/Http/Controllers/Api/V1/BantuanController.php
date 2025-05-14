<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Bantuan;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BantuanController extends Controller
{
    public function index()
    {
        $bantuan = Bantuan::with(['kategoriBantuan'])->paginate(10);
        return new ApiResource(true, 'Daftar Bantuan', $bantuan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'nullable|uuid',
            'nama_bantuan' => 'required|string|max:50',
            'kategori_bantuan_id' => 'required|exists:kategori_bantuan,id',
            // 'kategori_bantuan' => 'required|in:tunai,pangan,pendidikan,kesehatan,perumahan,lainnya',
            'nominal' => 'nullable|string|max:50',
            'periode' => 'required|string|max:50',
            'lama_periode' => 'required|string|max:50',
            'instansi' => 'required|string|max:50',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bantuan = Bantuan::create($request->all());

        return new ApiResource(true, 'Data Bantuan Berhasil Ditambahkan', $bantuan);
    }

    public function show(Bantuan $bantuan)
    {
        $bantuan->load('kategoriBantuan');
        return new ApiResource(true, 'Detail Data Bantuan', $bantuan);
    }

    public function update(Request $request, Bantuan $bantuan)
    {
        $validator = Validator::make($request->all(), [
            'nama_bantuan' => 'required|string|max:50',
            'kategori_bantuan_id' => 'required|exists:kategori_bantuan,id',
            // 'kategori_bantuan' => 'required|in:tunai,pangan,pendidikan,kesehatan,perumahan,lainnya',
            'nominal' => 'nullable|string|max:50',
            'periode' => 'required|string|max:50',
            'lama_periode' => 'required|string|max:50',
            'instansi' => 'required|string|max:50',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bantuan->update($request->all());

        return new ApiResource(true, 'Data Bantuan Berhasil Diubah', $bantuan);
    }

    public function destroy(Bantuan $bantuan)
    {
        $bantuan->delete();
        return new ApiResource(true, 'Data Bantuan Berhasil Dihapus', null);
    }
}
