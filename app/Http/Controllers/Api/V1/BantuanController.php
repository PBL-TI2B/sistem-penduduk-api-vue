<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Bantuan;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Http\Resources\BantuanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BantuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Bantuan::with('kategoriBantuan');

        // General search across main columns
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->Where('nama_bantuan', 'like', "%$search%")
                    ->orWhere('nominal', 'like', "%$search%")
                    ->orWhere('periode', 'like', "%$search%")
                    ->orWhere('lama_periode', 'like', "%$search%")
                    ->orWhere('instansi', 'like', "%$search%")
                    ->orWhere('keterangan', 'like', "%$search%");
            });
        }

        // Filtering
        if ($request->filled('kategori_bantuan_id')) {
            $query->where('kategori_bantuan_id', $request->kategori_bantuan_id);
        }

        $bantuan = $query->paginate($request->get('per_page', 10));
        $bantuan->setCollection(collect(BantuanResource::collection($bantuan->getCollection())));

        return new ApiResource(true, 'Daftar Bantuan', $bantuan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'nullable|uuid',
            'nama_bantuan' => 'required|string|max:50',
            'kategori_bantuan_id' => 'required|exists:kategori_bantuan,id',
            'nominal' => 'nullable|string|max:50',
            'periode' => 'required|string|max:50',
            'lama_periode' => 'required|string|max:50',
            'instansi' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $bantuan = Bantuan::create($validator->validated());
        $bantuan->load('kategoriBantuan');

        return new ApiResource(true, 'Data Bantuan Berhasil Ditambahkan', new BantuanResource($bantuan));
    }

    public function show(Bantuan $bantuan)
    {
        $bantuan->load('kategoriBantuan');
        return new ApiResource(true, 'Detail Data Bantuan', new BantuanResource($bantuan));
    }

    public function update(Request $request, Bantuan $bantuan)
    {
        $validator = Validator::make($request->all(), [
            'nama_bantuan' => 'required|string|max:50',
            'kategori_bantuan_id' => 'required|exists:kategori_bantuan,id',
            'nominal' => 'nullable|string|max:50',
            'periode' => 'required|string|max:50',
            'lama_periode' => 'required|string|max:50',
            'instansi' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $bantuan->update($validator->validated());
        $bantuan->load('kategoriBantuan');

        return new ApiResource(true, 'Data Bantuan Berhasil Diubah', new BantuanResource($bantuan));
    }

    public function destroy(Bantuan $bantuan)
    {
        $bantuan->delete();
        return new ApiResource(true, 'Data Bantuan Berhasil Dihapus', null);
    }
}
