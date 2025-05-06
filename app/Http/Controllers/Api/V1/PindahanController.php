<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Pindahan;
use Illuminate\Support\Facades\Validator;


class PindahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pindahan = Pindahan::with('penduduk')->paginate(10);
        return new ApiResource(true, 'Daftar Data Pindahan', $pindahan);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'status_pindahan' => 'required|in:masuk, keluar',
            'tanggal_pindahan'=> 'required|date',
            'alamat_asal_tujuan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pindahan = Pindahan::create([
            'penduduk_id' => $request->penduduk_id,
            'status_pindahan' => $request->status_pindahan,
            'tanggal_pindahan' => $request->tanggal_pindahan,
            'alamat_asal_tujuan' => $request->alamat_asal_tujuan,
        ]);

        return new ApiResource(true, 'Data Pindahan Berhasil Ditambahkan', $pindahan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pindahan $pindahan)
    {
        $pindahan->load('penduduk');
        return new ApiResource(true, 'Detail Data Pindahan', $pindahan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pindahan $pindahan)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
