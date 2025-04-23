<?php

namespace App\Http\Controllers\Api;

use App\Models\Kematian;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KematianController extends Controller
{
    public function index()
    {
        $kematian = Kematian::with(['penduduk'])->paginate(10);
        return new ApiResource(true, 'Daftar Data Kematian', $kematian);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_kematian' => 'required|date',
            'sebab_kematian' => 'required',
            'penduduk_id' => 'nullable|exists:penduduk,id'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kematian = Kematian::create([
            'tanggal_kematian' => $request->tanggal_kematian,
            'sebab_kematian' => $request->sebab_kematian,
            'penduduk_id' => $request->penduduk_id,
        ]);

        return new ApiResource(true, 'Data Kematian Berhasil Ditambahkan', $kematian);
    }
    public function show(Kematian $kematian): ApiResource
    {
        return new ApiResource(true, 'Detail Data Kematian', $kematian);
    }
    public function update(Request $request, Kematian $kematian)
    {
        $validator = Validator::make($request->all(),[
            'tanggal_kematian' => 'required|date',
            'sebab_kematian' => 'required',
            'penduduk_id' => 'nullable|exists:penduduk,id'
        ]);

        $data = $request->all();

        $kematian->update($data);

        return new ApiResource(true, 'Data Kematian Berhasil Diubah', $kematian);
    }
    public function destroy(Kematian $kematian)
    {
        $kematian->delete();
        return new ApiResource(true, 'Data Kematian Berhasil Dihapus', null);
    }
}
