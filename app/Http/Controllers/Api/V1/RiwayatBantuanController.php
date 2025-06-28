<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatBantuan;
use App\Models\PenerimaBantuan;
use App\Http\Resources\ApiResource;
use App\Http\Resources\RiwayatBantuanResource;
use Illuminate\Support\Facades\Validator;

class RiwayatBantuanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);

        // Hanya ambil data jika parameter penerima_bantuan_id ada
        if (!$request->filled('penerima_bantuan_id')) {
            $emptyPaginator = (new RiwayatBantuan())->newQuery()->whereRaw('1=0')->paginate($perPage);
            $emptyPaginator->setCollection(collect([]));
            return new ApiResource(true, 'Daftar Data Riwayat Bantuan', $emptyPaginator);
        }

        $query = RiwayatBantuan::query();
        $query->where('penerima_bantuan_id', $request->penerima_bantuan_id);

        $data = $query->paginate($perPage);
        $collection = RiwayatBantuanResource::collection($data->getCollection());
        $data->setCollection(collect($collection));

        return new ApiResource(true, 'Daftar Data Riwayat Bantuan', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penerima_bantuan_id' => 'required|exists:penerima_bantuan,id',
            // 'status_pencairan' => 'required|in:diterima, diproses, belum diterima',
            'tanggal_penerimaan' => 'required|date',
            // 'dokumentasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors(), 422);
        }

        $validated = $validator->validated();

        // Cek status pada tabel induk (PenerimaBantuan dan Bantuan)
        $penerimaBantuan = PenerimaBantuan::with('bantuan')->find($validated['penerima_bantuan_id']);
        if ($penerimaBantuan->status !== 'aktif') {
            return new ApiResource(false, 'Pencairan tidak dapat ditambahkan karena status penerima bantuan tidak aktif.', null, 403);
        }

        if ($penerimaBantuan->bantuan->status !== 'aktif') {
            return new ApiResource(false, 'Pencairan tidak dapat ditambahkan karena program bantuan ini tidak aktif.', null, 403);
        }

        $validated['status'] = 'diproses';
        $data = RiwayatBantuan::create($validated);

        return new ApiResource(true, 'Data Riwayat Bantuan berhasil ditambahkan', new RiwayatBantuanResource($data), 201);
    }

    public function show(RiwayatBantuan $riwayatBantuan)
    {
        return new ApiResource(true, 'Detail Riwayat Bantuan', new RiwayatBantuanResource($riwayatBantuan));
    }

    public function update(Request $request, RiwayatBantuan $riwayatBantuan)
    {
        // Cegah update jika status sudah 'diterima'
        if ($riwayatBantuan->status === 'diterima') {
            return new ApiResource(false, 'Data tidak dapat diubah karena status sudah diterima', null, 403);
        }

        if ($request->has('status')) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:diterima,belum diterima',
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

        $riwayatBantuan->update($data);

        return new ApiResource(true, 'Data Riwayat Bantuan berhasil diperbarui', new RiwayatBantuanResource($riwayatBantuan));
    }

    public function destroy(RiwayatBantuan $riwayatBantuan)
    {
        $riwayatBantuan->delete();

        return new ApiResource(true, 'Data Riwayat Bantuan berhasil dihapus', null);
    }
}