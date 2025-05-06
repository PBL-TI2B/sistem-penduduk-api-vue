<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\KurangMampu;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KurangMampuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kurangMampu = KurangMampu::with(['anggotaKeluarga'])->paginate(10);
        return new ApiResource(true, 'Daftar Data Kurang Mampu', $kurangMampu);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pendapatan_per_hari' => 'nullable|string',
            'pendapatan_per_bulan' => 'nullable|string',
            'jumlah_tanggungan' => 'nullable|string',
            'status_validasi' => 'required|in:pending,terverifikasi,ditolak',
            'keterangan' => 'nullable|string',
            'anggota_keluarga_id' => 'nullable|exists:anggota_keluarga,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kurangMampu = KurangMampu::create([
            'pendapatan_per_hari' => $request->pendapatan_per_hari,
            'pendapatan_per_bulan' => $request->pendapatan_per_bulan,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'status_validasi' => $request->status_validasi,
            'keterangan' => $request->keterangan,
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
        ]);

        return new ApiResource(true, 'Data Kurang Mampu Berhasil Ditambahkan', $kurangMampu);
    }

    /**
     * Display the specified resource.
     */
    public function show(KurangMampu $kurangMampu)
    {
        return new ApiResource(true, 'Detail Data Kurang Mampu', $kurangMampu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KurangMampu $kurangMampu)
    {
        $validator = Validator::make($request->all(),[
            'pendapatan_per_hari' => 'nullable|string',
            'pendapatan_per_bulan' => 'nullable|string',
            'jumlah_tanggungan' => 'nullable|string',
            'status_validasi' => 'required|in:pending,terverifikasi,ditolak',
            'keterangan' => 'nullable|string',
            'anggota_keluarga_id' => 'nullable|exists:anggota_keluarga,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();

        $kurangMampu->update($data);

        return new ApiResource(true, 'Data Kurang Mampu Berhasil Diubah', $kurangMampu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KurangMampu $kurangMampu)
    {
        $kurangMampu->delete();
        return new ApiResource(true, 'Data Kurang Mampu Berhasil Dihapus', null);
    }
}
