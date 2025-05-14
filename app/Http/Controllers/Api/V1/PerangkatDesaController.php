<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PerangkatDesa;
use App\Http\Resources\ApiResource;
use App\Http\Resources\PerangkatDesaResource;
use App\Http\Resources\PaginatedResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        // Fetch all perangkat desa
        $perangkatDesa = PerangkatDesa::with(['penduduk', 'jabatan', 'periode_jabatan', 'desa', 'dusun', 'rw', 'rt'])->paginate(10);
        $collection = PerangkatDesaResource::collection($perangkatDesa->getCollection());
        $perangkatDesa->setCollection(collect($collection));
        
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data perangkat desa',
            'data' => $perangkatDesa,
        ]);
    }

    public function store(Request $request)
    {
        // Validate and create a new perangkat desa
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'periode_jabatan_id' => 'required|exists:periode_jabatan,id',
            'status_keaktifan' => 'required|in:aktif,tak aktif',
            'desa_id' => 'nullable|exists:desa,id',
            'dusun_id' => 'nullable|exists:dusun,id',
            'rw_id' => 'nullable|exists:rw,id',
            'rt_id' => 'nullable|exists:rt,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $perangkatDesa = PerangkatDesa::create([
            'penduduk_id' => $request->penduduk_id,
            'jabatan_id' => $request->jabatan_id,
            'periode_jabatan_id' => $request->periode_jabatan_id,
            'status_keaktifan' => $request->status_keaktifan,
            'desa_id' => $request->desa_id,
            'dusun_id' => $request->dusun_id,
            'rw_id' => $request->rw_id,
            'rt_id' => $request->rt_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Perangkat Desa Created',
            'data' => new PerangkatDesaResource($perangkatDesa),
        ]);
    }

    public function show(PerangkatDesa $perangkatDesa)
    {
        $perangkatDesa->load(['penduduk', 'jabatan', 'periode_jabatan', 'desa', 'dusun', 'rw', 'rt']);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data perangkat desa',
            'data' => new PerangkatDesaResource($perangkatDesa->load(['penduduk', 'jabatan', 'periode_jabatan', 'desa', 'dusun', 'rw', 'rt'])),
        ]);
    }

    public function update(Request $request, PerangkatDesa $perangkatDesa)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'periode_jabatan_id' => 'required|exists:periode_jabatan,id',
            'status_keaktifan' => 'required|in:aktif,tak aktif',
            'desa_id' => 'nullable|exists:desa,id',
            'dusun_id' => 'nullable|exists:dusun,id',
            'rw_id' => 'nullable|exists:rw,id',
            'rt_id' => 'nullable|exists:rt,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $request->all();
        $perangkatDesa->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Perangkat Desa Updated',
            'data' => new PerangkatDesaResource($perangkatDesa),
        ]);
    }

    public function destroy(PerangkatDesa $perangkatDesa)
    {
        // Delete a specific perangkat desa
        $perangkatDesa->delete();
        return response()->json([
            'success' => true,
            'message' => 'Perangkat Desa Deleted',
            'data' => null,
        ]);
    }

    public function exportPdf()
    {
        $perangkatDesa = PerangkatDesa::get();
        $pdf = \PDF::loadView('exports.perangkat-desa', compact('perangkatDesa'));
        return $pdf->download('perangkat-desa.pdf');
    }
}