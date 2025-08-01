<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PerangkatDesa;
use App\Models\PeriodeJabatan;
use Illuminate\Support\Str;
use App\Http\Resources\ApiResource;
use App\Http\Resources\PerangkatDesaResource;
use App\Http\Resources\PaginatedResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PerangkatDesaController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dengan relasi yang diperlukan
        $query = PerangkatDesa::with(['penduduk', 'jabatan', 'periode_jabatan', 'desa', 'dusun', 'rw', 'rt']);

        // Filter berdasarkan periode_jabatan_id
        if ($request->filled('periode_jabatan')) {
            $query->whereHas('periode_jabatan', function ($q) use ($request) {
                $q->where('id', $request->periode_jabatan);
            });
        }

        // Filter berdasarkan jabatan_id
        if ($request->filled('jabatan')) {
            $query->whereHas('jabatan', function ($q) use ($request) {
                $q->where('id', $request->jabatan);
            });
        }

        // Filter berdasarkan rw_id
        if ($request->filled('rw')) {
            $query->whereHas('rw', function ($q) use ($request) {
                $q->where('id', $request->rw);
            });
        }

        // Filter berdasarkan status_keaktifan
        if ($request->filled('status_keaktifan') && $request->status_keaktifan !== '-') {
            $query->where('status_keaktifan', $request->status_keaktifan);
        }

        // --- KOREKSI PENTING DI SINI: Perbaikan Logika Pencarian ---
        // Gunakan has() untuk memeriksa keberadaan parameter, dan pastikan tidak null
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search; // Ambil nilai pencarian (bisa string kosong)
            // Hanya terapkan filter LIKE jika string pencarian tidak kosong
            if (!empty($search)) {
                $query->whereHas('penduduk', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%');
                });
            }
        }
        // --- AKHIR KOREKSI ---

        // Pagination (default 10)
        $perangkatDesa = $query->paginate($request->get('per_page', 10));

        // Gunakan resource untuk data
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
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'periode_jabatan_id' => 'required',
            'status_keaktifan' => 'required|in:aktif,nonaktif',
            'desa_id' => 'nullable|exists:desa,id',
            'dusun_id' => 'nullable|exists:dusun,id',
            'rw_id' => 'nullable|exists:rw,id',
            'rt_id' => 'nullable|exists:rt,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();
        $periodeValue = $validated['periode_jabatan_id'];

        if (is_numeric($periodeValue)) {
            $periodeJabatanId = (int) $periodeValue;
        } else {
            [$awal, $akhir] = explode('-', $periodeValue);

            $periode = PeriodeJabatan::create([
                'uuid' => Str::uuid(),
                'awal_menjabat' => trim($awal) . '-01-01',
                'akhir_menjabat' => trim($akhir) . '-12-31',
                'keterangan' => 'Diinput manual saat tambah perangkat',
            ]);

            $periodeJabatanId = $periode->id;
        }

        $perangkatDesa = PerangkatDesa::create([
            'penduduk_id' => $request->penduduk_id,
            'jabatan_id' => $request->jabatan_id,
            'periode_jabatan_id' => $periodeJabatanId,
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
            'periode_jabatan_id' => 'required',
            'status_keaktifan' => 'required|in:aktif,nonaktif',
            'desa_id' => 'nullable|exists:desa,id',
            'dusun_id' => 'nullable|exists:dusun,id',
            'rw_id' => 'nullable|exists:rw,id',
            'rt_id' => 'nullable|exists:rt,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();
        $periodeValue = $validated['periode_jabatan_id'];

        if (is_numeric($periodeValue)) {
            $periodeJabatanId = (int) $periodeValue;
        } else {
            [$awal, $akhir] = explode('-', $periodeValue);

            $periode = PeriodeJabatan::create([
                'uuid' => Str::uuid(),
                'awal_menjabat' => trim($awal) . '-01-01',
                'akhir_menjabat' => trim($akhir) . '-12-31',
                'keterangan' => 'Diinput manual saat tambah perangkat',
            ]);

            $periodeJabatanId = $periode->id;
        }

        $validated['periode_jabatan_id'] = $periodeJabatanId;

        $perangkatDesa->update($validated);


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
