<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AnggotaKeluarga;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnggotaKeluargaController extends Controller
{
    public function index(Request $request)
    {
        //! Mengambil data anggota keluarga dengan relasi yang diperlukan
        $query = AnggotaKeluarga::with([
            'kk',
            // 'penduduk.domisili.rt.rw.dusun',
            'penduduk',
            'statusKeluarga'
        ])
            ->withCount('kurangMampu');

        //! Filter Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                // Cari di penduduk (nama_lengkap, nik)
                $query->whereHas('penduduk', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%$search%")
                        ->orWhere('nik', 'like', "%$search%");
                })

                    // Cari di relasi pekerjaan
                    ->orWhereHas('penduduk.pekerjaan', function ($q) use ($search) {
                        $q->where('nama_pekerjaan', 'like', "%$search%");
                    })

                    // Cari di relasi pendidikan
                    ->orWhereHas('penduduk.pendidikan', function ($q) use ($search) {
                        $q->where('jenjang', 'like', "%$search%");
                    })

                    // Cari di relasi status keluarga
                    ->orWhereHas('statusKeluarga', function ($q) use ($search) {
                        $q->where('status_keluarga', 'like', "%$search%");
                    })
                ;
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
        $pdf = Pdf::loadView('exports.anggota-keluarga', compact('anggotaKeluarga'));
        return $pdf->download('anggota-keluarga.pdf');
    }

    public function storeBatch(Request $request)
    {
        $data = $request->all();

        foreach ($data as $item) {
            AnggotaKeluarga::create([
                'kk_id' => $item['kk_id'],
                'penduduk_id' => $item['penduduk_id'],
                'status_keluarga_id' => $item['status_keluarga_id'],
            ]);
        }

        return response()->json(['message' => 'Anggota keluarga ditambahkan'], 201);
    }
}
