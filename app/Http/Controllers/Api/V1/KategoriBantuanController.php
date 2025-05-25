<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KategoriBantuan;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriBantuanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = KategoriBantuan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('kategori', 'like', '%' . $search . '%');
        }

        // Cek parameter 'all' untuk mengambil semua data tanpa pagination
        if ($request->boolean('all')) {
            $data = $query->get(); // Ambil semua data
        } else {
            $data = $query->withCount('bantuan')->paginate($perPage); // Pagination
        }

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

        try {
            $kategori = KategoriBantuan::create([
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori bantuan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }

        return new ApiResource(true, 'Kategori Bantuan Berhasil Ditambahkan', $kategori);
    }

    public function show($uuid)
    {
        $data = KategoriBantuan::with('bantuan')->where('uuid', $uuid)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori Bantuan tidak ditemukan',
                'data' => null
            ], 404);
        }

        return new ApiResource(true, 'Detail Kategori Bantuan', $data);
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategoriBantuan = KategoriBantuan::where('uuid', $uuid)->first();

        if (!$kategoriBantuan) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori Bantuan tidak ditemukan',
                'data' => null
            ], 404);
        }

        try {
            $kategoriBantuan->update([
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kategori bantuan: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }

        return new ApiResource(true, 'Kategori Bantuan Berhasil Diperbarui', $kategoriBantuan);
    }

    public function destroy($uuid)
    {
        $data = KategoriBantuan::where('uuid', $uuid)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori Bantuan tidak ditemukan',
                'data' => null
            ], 404);
        }

        $data->delete();

        return new ApiResource(true, "Kategori Bantuan '" . $data->kategori . "' Berhasil Dihapus", null);
    }
}
