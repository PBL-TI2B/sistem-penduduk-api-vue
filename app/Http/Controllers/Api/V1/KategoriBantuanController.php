<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KategoriBantuan;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriBantuanController extends Controller
{
    public function index()
    {
        $data = KategoriBantuan::with('bantuan')->paginate(10);
        return new ApiResource(true, 'Daftar Kategori Bantuan', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategori = KategoriBantuan::create([
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
        ]);

        return new ApiResource(true, 'Kategori Bantuan Berhasil Ditambahkan', $kategori);
    }

    public function show(KategoriBantuan $kategoriBantuan)
    {
        return new ApiResource(true, 'Detail Kategori Bantuan', $kategoriBantuan->load('bantuan'));
    }

    public function update(Request $request, KategoriBantuan $kategoriBantuan)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategoriBantuan->update($request->all());

        return new ApiResource(true, 'Kategori Bantuan Berhasil Diupdate', $kategoriBantuan);
    }

    public function destroy(KategoriBantuan $kategoriBantuan)
    {
        $kategoriBantuan->delete();
        return new ApiResource(true, 'Kategori Bantuan Berhasil Dihapus', null);
    }
}
