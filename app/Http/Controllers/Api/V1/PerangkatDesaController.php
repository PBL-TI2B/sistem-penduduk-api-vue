<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PerangkatDesa;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        // Fetch all perangkat desa
        $perangkatDesa = PerangkatDesa::with(['penduduk', 'jabatan', 'periode_jabatan', 'desa', 'dusun', 'rw', 'rt'])->paginate(10);
        return new ApiResource(true, 'Daftar Perangkat Desa', $perangkatDesa);
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

        return new ApiResource(true, 'Perangkat Desa Created', $perangkatDesa);
    }

    public function show($uuid)
    {
        // Fetch a specific perangkat desa by UUID
        $perangkatDesa = load(['penduduk', 'jabatan', 'periode_jabatan', 'desa', 'dusun', 'rw', 'rt']);

        return new ApiResource(true, 'Detail Perangkat Desa', $perangkatDesa);
    }
}