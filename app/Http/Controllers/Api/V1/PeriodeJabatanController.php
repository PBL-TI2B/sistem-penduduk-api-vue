<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PeriodeJabatan;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodeJabatanController extends Controller
{
    public function index(Request $request)
    {
        $periodeJabatan = PeriodeJabatan::paginate(10);
        return new ApiResource(true, 'Daftar Data Periode Jabatan', $periodeJabatan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'awal_menjabat' => 'required|date',
            'akhir_menjabat' => 'required|date|after:awal_menjabat',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $periodeJabatan = PeriodeJabatan::create([
            'awal_menjabat' => $request->awal_menjabat,
            'akhir_menjabat' => $request->akhir_menjabat,
            'keterangan' => $request->keterangan,
        ]);

        return new ApiResource(true, 'Data Periode Jabatan Baru Berhasil Ditambahkan', $periodeJabatan);
    }

    public function show(PeriodeJabatan $periodeJabatan)
    {
        return new ApiResource(true, 'Detail Data Periode Jabatan', $periodeJabatan);
    }

    public function update(Request $request, PeriodeJabatan $periodeJabatan)
    {
        $validator = Validator::make($request->all(), [
            'awal_menjabat' => 'required|date',
            'akhir_menjabat' => 'required|date|after:awal_menjabat',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $periodeJabatan->update([
            'awal_menjabat' => $request->awal_menjabat,
            'akhir_menjabat' => $request->akhir_menjabat,
            'keterangan' => $request->keterangan,
        ]);

        return new ApiResource(true, 'Data Periode Jabatan Berhasil Diperbarui', $periodeJabatan);
    }

    public function destroy(PeriodeJabatan $periodeJabatan)
    {
        $periodeJabatan->delete();
        return new ApiResource(true, 'Data Periode Jabatan Berhasil Dihapus', null);
    }
}
