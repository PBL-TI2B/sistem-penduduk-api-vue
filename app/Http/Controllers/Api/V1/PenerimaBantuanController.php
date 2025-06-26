<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Resources\ApiResource;
use App\Models\PenerimaBantuan;
use App\Http\Resources\PenerimaBantuanResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PenerimaBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = PenerimaBantuan::query();

        //! Filter Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                // Cari di penduduk (nama_lengkap, nik)
                $query->whereHas('kurangMampu.anggotaKeluarga.penduduk', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%$search%")
                        ->orWhere('nik', 'like', "%$search%");
                })

                    // Cari di relasi bantuan
                    ->orWhereHas('bantuan', function ($q) use ($search) {
                        $q->where('nama_bantuan', 'like', "%$search%");
                    });
            });
        }

        //! Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->withCount('riwayatBantuan')->with(['bantuan.kategoriBantuan', 'kurangMampu.anggotaKeluarga.penduduk'])->paginate($perPage);
        // $data = $query->paginate($perPage);
        $collection = PenerimaBantuanResource::collection($data->getCollection());
        $data->setCollection(collect($collection));

        return new ApiResource(true, 'Daftar Data Penerima Bantuan', $data);
    }

    // $table->timestamps();
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kurang_mampu_id' => 'required|exists:kurang_mampu,id',
            'bantuan_id' => 'required|exists:bantuan,id',
            'tanggal_penerimaan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors(), 422);
        }

        // Cek kombinasi kurang_mampu_id dan bantuan_id sudah ada atau belum
        $exists = PenerimaBantuan::where('kurang_mampu_id', $request->kurang_mampu_id)
            ->where('bantuan_id', $request->bantuan_id)
            ->exists();

        if ($exists) {
            return new ApiResource(false, 'Data dengan Penduduk Kurang Mampu dan Bantuan yang sama sudah', null, 409);
        }

        $tanggal_penerimaan = Carbon::parse($request->tanggal_penerimaan)->format('Y-m-d');

        $data = PenerimaBantuan::create([
            'kurang_mampu_id' => $request->kurang_mampu_id,
            'bantuan_id' => $request->bantuan_id,
            'status' => 'diajukan',
            'tanggal_penerimaan' => $tanggal_penerimaan,
            'keterangan' => $request->keterangan,
        ]);

        return new ApiResource(true, 'Data berhasil ditambahkan', new PenerimaBantuanResource($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaBantuan $penerimaBantuan)
    {

        $penerimaBantuan->load([
            'bantuan.kategoriBantuan',
            'kurangMampu.anggotaKeluarga.penduduk',
            // 'riwayatBantuan'
        ]);
        return new ApiResource(true, 'Detail Data Penerima Bantuan', new PenerimaBantuanResource($penerimaBantuan));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaBantuan $penerimaBantuan, Request $request)
    {

        if ($request->has('status')) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:aktif,selesai,ditolak',
            ]);
            $data = $request->only('status');
        } else {
            $validator = Validator::make($request->all(), [
                'keterangan' => 'nullable|string',
            ]);
            $data = $request->only('keterangan');
        }

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors(), 422);
        }
        // $data = $request->only(['status', 'keterangan']);

        $penerimaBantuan->update($data);

        return new ApiResource(true, 'Data berhasil diperbarui', new PenerimaBantuanResource($penerimaBantuan));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaBantuan $penerimaBantuan)
    {
        $penerimaBantuan->delete();
        return new ApiResource(true, 'Data penerima bantuan berhasil dihapus', null);
    }

    public function exportPdf()
    {
        $kurangMampu = PenerimaBantuan::get();
        $pdf = Pdf::loadView('exports.penerima-bantuan', compact('penerimaBantuan'));
        return $pdf->download('penerima-bantuan.pdf');
    }
}
