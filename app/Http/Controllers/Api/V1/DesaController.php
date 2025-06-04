<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Desa;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DesaController extends Controller
{
    public function index(Request $request)
    {
        $query = Desa::query();

        // Fitur pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                ->orWhere('deskripsi', 'like', "%$search%")
                ->orWhere('lokasi', 'like', "%$search%");
            });
        }
        $query->withCount ('perangkatDesa', 'dusun');

        // Paginasi
        $desa = $query->paginate($request->get('per_page', 10));

        // Respon API
        return new ApiResource(true, 'Daftar Data Desa', $desa);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $desa = Desa::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
        ]);

        return new ApiResource(true, 'Data Desa Baru Berhasil Ditambahkan', $desa);
    }

    public function show(Desa $desa)
    {
        return new ApiResource(true, 'Detail Data Desa', $desa);
    }

    public function update(Request $request, Desa $desa)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $desa->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
        ]);

        return new ApiResource(true, 'Data Desa Berhasil Diperbarui', $desa);
    }

    public function destroy(Desa $desa)
    {
        $desa->delete();
        return new ApiResource(true, 'Data Desa Berhasil Dihapus', null);
    }
}
