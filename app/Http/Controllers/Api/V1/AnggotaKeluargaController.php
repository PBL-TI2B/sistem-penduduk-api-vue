<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AnggotaKeluarga;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnggotaKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaKeluarga::with(['kk', 'penduduk', 'statusKeluarga']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('penduduk', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%");
            });
        }

        $anggota = $query->paginate($request->get('per_page', 10));

        return new ApiResource(true, 'Daftar Data Anggota Keluarga', $anggota);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kk_id' => 'required|exists:kartu_keluarga,id',
            'penduduk_id' => 'required|exists:penduduk,id',
            'status_keluarga_id' => 'required|exists:status_keluarga,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $anggota = AnggotaKeluarga::create([
            'kk_id' => $request->kk_id,
            'penduduk_id' => $request->penduduk_id,
            'status_keluarga_id' => $request->status_keluarga_id,
        ]);

        return new ApiResource(true, 'Anggota Keluarga Berhasil Ditambahkan', $anggota);
    }

    public function show(AnggotaKeluarga $anggotaKeluarga)
    {
        return new ApiResource(true, 'Detail Data Anggota Keluarga', $anggotaKeluarga);
    }

    public function update(Request $request, AnggotaKeluarga $anggotaKeluarga)
    {
        $validator = Validator::make($request->all(), [
            'kk_id' => 'required|exists:kartu_keluarga,id',
            'penduduk_id' => 'required|exists:penduduk,id',
            'status_keluarga_id' => 'required|exists:status_keluarga,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $anggotaKeluarga->update([
            'kk_id' => $request->kk_id,
            'penduduk_id' => $request->penduduk_id,
            'status_keluarga_id' => $request->status_keluarga_id,
        ]);

        return new ApiResource(true, 'Data Anggota Keluarga Berhasil Diubah', $anggotaKeluarga);
    }

    public function destroy(AnggotaKeluarga $anggotaKeluarga)
    {
        $anggotaKeluarga->delete();
        return new ApiResource(true, 'Data Anggota Keluarga Berhasil Dihapus', null);
    }

    public function exportPdf()
    {
        $anggotaKeluarga = AnggotaKeluarga::get();
        $pdf = \PDF::loadView('exports.anggota-keluarga', compact('anggotaKeluarga'));
        return $pdf->download('anggota-keluarga.pdf');
    }
}
