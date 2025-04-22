<?php

namespace App\Http\Controllers\Api;

use App\Models\Kelahiran;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KelahiranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelahiran = Kelahiran::with(['penduduk'])->paginate(5);
        return new ApiResource(true, 'Daftar Data Kelahiran', $kelahiran);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'anak_ke' => 'required',
            'berat' => 'nullable',
            'panjang' => 'nullable',
            'waktu_kelahiran' => 'nullable',
            'lokasi' => 'nullable',
            'keterangan' => 'nullable',
            'penduduk_id' => 'nullable|exists:penduduk,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kelahiran = Kelahiran::create([
            'anak_ke' => $request->anak_ke,
            'berat' => $request->berat,
            'panjang' => $request->panjang,
            'waktu_kelahiran' => $request->waktu_kelahiran,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'penduduk_id' => $request->penduduk_id,
        ]);

        return new ApiResource(true, 'Data Kelahiran Berhasil Ditambahkan', $kelahiran);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelahiran $kelahiran)
    {
        return new ApiResource(true, 'Detail Data Kelahiran', $kelahiran);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelahiran $kelahiran)
    {
        $validator = Validator::make($request->all(),[
            'anak_ke' => 'required',
            'berat' => 'nullable',
            'panjang' => 'nullable',
            'waktu_kelahiran' => 'nullable',
            'lokasi' => 'nullable',
            'keterangan' => 'nullable',
            'penduduk_id' => 'nullable|exists:penduduk,id'
        ]);

        $data = $request->all();

        $kelahiran->update($data);

        return new ApiResource(true, 'Data Kelahiran Berhasil Diubah', $kelahiran);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelahiran $kelahiran)
    {
        $kelahiran->delete();
        return new ApiResource(true, 'Data Kelahiran Berhasil Dihapus');
    }
}