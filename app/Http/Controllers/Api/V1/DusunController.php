<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Dusun;
use App\Http\Resources\ApiResource;
use App\Http\Resources\DusunResource;
use App\Http\Resources\PaginatedResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DusunController extends Controller
{
    public function index()
    {
        $dusun = Dusun::with(['desa'])->paginate(10);
        $collection = DusunResource::collection($dusun->getCollection());
        $dusun->setCollection(collect($collection));

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data dusun',
            'data' => $dusun,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'desa_id' => 'required|exists:desa,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dusun = Dusun::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'desa_id' => $request->desa_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dusun Created',
            'data' => new DusunResource($dusun),
        ]);
    }

    public function show(Dusun $dusun)
    {
        $dusun->load(['desa']);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data dusun',
            'data' => new DusunResource($dusun),
        ]);
    }

    public function update(Request $request, Dusun $dusun)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'desa_id' => 'required|exists:desa,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dusun->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'desa_id' => $request->desa_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dusun Updated',
            'data' => new DusunResource($dusun),
        ]);
    }

    public function destroy(Dusun $dusun)
    {
        $dusun->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dusun Deleted',
        ]);
    }
}
