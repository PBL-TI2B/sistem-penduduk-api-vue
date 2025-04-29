<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Notifikasi_Penerima;
use Illuminate\Support\Facades\Validator;

class NotifikasiPenerimaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifikasiPenerima = Notifikasi_Penerima::with('notifikasi', 'users')->paginate(10);
        return new ApiResource(true, 'Daftar Data Notifikasi Penerima', $notifikasiPenerima);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notifikasi_id' => 'required|exists:notifikasi,id',
            'penerima_id'   => 'required|exists:penduduk,id',
            'status_baca'   => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $notifikasiPenerima = Notifikasi_Penerima::create([
            'notifikasi_id' => $request->notifikasi_id,
            'penerima_id'   => $request->penerima_id,
            'status_baca'   => $request->status_baca,
        ]);

        return new ApiResource(true, 'Notifikasi Penerima Berhasil Ditambahkan', $notifikasiPenerima);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notifikasi_Penerima $notifikasiPenerima)
    {
        $notifikasiPenerima ->load('notifikasi', 'users');
        return new ApiResource(true, 'Detail Data Notifikasi Penerima', $notifikasiPenerima);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notifikasi_Penerima $notifikasiPenerima)
    {
        $validator = Validator::make($request->all(), [
            'notifikasi_id' => 'required|exists:notifikasi,id',
            'penerima_id'   => 'required|exists:penduduk,id',
            'status_baca'   => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $notifikasiPenerima->update($data);

        return new ApiResource(true, 'Notifikasi Penerima Berhasil Diupdate', $notifikasiPenerima);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notifikasi_Penerima $notifikasiPenerima)
    {
        $notifikasiPenerima->delete();
        return new ApiResource(true, 'Notifikasi Penerima Berhasil Dihapus', null);
    }
}
