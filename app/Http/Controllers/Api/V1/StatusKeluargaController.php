<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\StatusKeluarga;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StatusKeluargaController extends Controller
{
    public function index()
    {
        $data = StatusKeluarga::all();
        return new ApiResource(true, 'Daftar Status Keluarga', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status_keluarga' => 'required|unique:status_keluarga,status_keluarga|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = StatusKeluarga::create([
            'id' => (string) Str::uuid(),
            'status_keluarga' => $request->status_keluarga
        ]);

        return new ApiResource(true, 'Status Keluarga Berhasil Ditambahkan', $data);
    }

    public function show($id)
    {
        $data = StatusKeluarga::find($id);
        if (!$data) {
            return response()->json(['message' => 'Status Keluarga tidak ditemukan'], 404);
        }
        return new ApiResource(true, 'Detail Status Keluarga', $data);
    }

    public function update(Request $request, $id)
    {
        $data = StatusKeluarga::find($id);
        if (!$data) {
            return response()->json(['message' => 'Status Keluarga tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status_keluarga' => 'required|max:50|unique:status_keluarga,status_keluarga,' . $id . ',id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data->update([
            'status_keluarga' => $request->status_keluarga
        ]);

        return new ApiResource(true, 'Status Keluarga Berhasil Diupdate', $data);
    }

    public function destroy($id)
    {
        $data = StatusKeluarga::find($id);
        if (!$data) {
            return response()->json(['message' => 'Status Keluarga tidak ditemukan'], 404);
        }

        $data->delete();

        return new ApiResource(true, 'Status Keluarga Berhasil Dihapus', null);
    }
}
