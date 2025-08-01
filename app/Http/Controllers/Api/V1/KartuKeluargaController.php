<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\KartuKeluarga;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\KartuKeluargaResource;

class KartuKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = KartuKeluarga::query()->with([
            'rt', 
            'anggotaKeluarga.penduduk', 
            'anggotaKeluarga.statusKeluarga'
        ]);
        
        if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function ($q) use ($search) {
        $q->where('nomor_kk', 'like', "%$search%")
          ->orWhereHas('anggotaKeluarga', function ($subQ) use ($search) {
              $subQ->where('status_keluarga_id', 1) // kepala keluarga
                   ->whereHas('penduduk', function ($pendudukQ) use ($search) {
                       $pendudukQ->where('nama_lengkap', 'like', "%$search%");
                   });
          });
    });
}

        if ($request->filled('status_perkawinan') && $request->status_perkawinan !== '-') {
    $query->whereHas('anggotaKeluarga.penduduk', function ($q) use ($request) {
        $q->where('status_perkawinan', $request->status_perkawinan);
    });
}


if ($request->filled('rt') && $request->rt !== '-') {
    $query->whereHas('rt', function ($q) use ($request) {
        $q->where('nomor_rt', $request->rt); // ✅ sesuai kolom di tabel
    });
}


        if ($user) {
            if ($user->hasRole('rt') && $user->perangkatDesa?->rt_id) {
                $query->where('rt_id', $user->perangkatDesa->rt_id);

            } elseif ($user->hasRole('rw') && $user->perangkatDesa?->rw_id) {
                $userRw = $user->perangkatDesa->rw_id;
                $query->whereHas('rt', function ($q) use ($userRw) {
                    $q->where('rw_id', $userRw);
                });
            }
        }
        
        $kartukeluarga = $query->paginate($request->get('per_page', 10));
        return new ApiResource(true, 'Daftar Kartu Keluarga', $kartukeluarga);
    }

    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nomor_kk' => 'required|unique:kartu_keluarga,nomor_kk|max:50',
            'rt_id' => 'required',
            'kode_pos' => 'required|max:50',
            'kelurahan' => 'required|max:50',
            'kecamatan' => 'required|max:50',
            'kabupaten' => 'required|max:50',
            'provinsi' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Menyimpan data Kartu Keluarga baru
        $data = KartuKeluarga::create([
            'uuid' => (string) Str::uuid(),
            'nomor_kk' => $request->nomor_kk,
            'rt_id' => $request->rt_id,
            'kode_pos' => $request->kode_pos,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
        ]);

        return new ApiResource(true, 'Kartu Keluarga Berhasil Ditambahkan', $data);
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        // Menampilkan detail Kartu Keluarga
        $kartuKeluarga->load(['rt.rw', 'anggotaKeluarga.penduduk', 'anggotaKeluarga.statusKeluarga']);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil detail data kartu keluarga',
            'data' => new KartuKeluargaResource($kartuKeluarga),
        ]);
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        // Validasi data yang diperbarui
        $validator = Validator::make($request->all(), [
            'nomor_kk' => 'required|max:50|unique:kartu_keluarga,nomor_kk,' . $kartuKeluarga->uuid . ',uuid',
            'rt_id' => 'required',
            'kode_pos' => 'required|max:50',
            'kelurahan' => 'required|max:50',
            'kecamatan' => 'required|max:50',
            'kabupaten' => 'required|max:50',
            'provinsi' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update data Kartu Keluarga
        $kartuKeluarga->update($request->only([
            'nomor_kk',
            'rt_id',
            'kode_pos',
            'kelurahan',
            'kecamatan',
            'kabupaten',
            'provinsi'
        ]));

        return new ApiResource(true, 'Kartu Keluarga Berhasil Diperbarui', $kartuKeluarga);
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        // Hapus data Kartu Keluarga
        $kartuKeluarga->delete();
        return new ApiResource(true, 'Kartu Keluarga Berhasil Dihapus', null);
    }

    public function checkNomorKK(Request $request) 
    {
        $request->validate(['nomor_kk' => 'required|string']);

        $query = KartuKeluarga::where('nomor_kk', $request->nomor_kk);

        if ($request->filled('ignore_uuid')) {
            $query->where('uuid', '!=', $request->ignore_uuid);
        }

        $exists = $query->exists();

        return response()->json([
            'isAvailable' => !$exists, 
        ]);
    }
}
