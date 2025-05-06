<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifikasi = Notifikasi::with('users')->paginate(10);
        return new ApiResource(true, 'Daftar Notifikasi', $notifikasi);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aksi_user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:tambah,ubah,hapus',
            'deskripsi' => 'nullable',
            'waktu_aksi' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $notifikasi = Notifikasi::create([
            'aksi_user_id' => $request->aksi_user_id,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'waktu_aksi' => $request->waktu_aksi,
        ]);

        return new ApiResource(true, 'Notifikasi Berhasil Ditambahkan', $notifikasi);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notifikasi $notifikasi)
    {
        $notifikasi->load('users');
        return new ApiResource(true, 'Detail Notifikasi', $notifikasi);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notifikasi $notifikasi)
    {
        $validator = Validator::make($request->all(), [
            'aksi_user_id' => 'required|exists:users,id',
            'jenis' => 'require|in:tambah,ubah,hapus',
            'deskripsi' => 'nullable',
            'waktu_aksi' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $notifikasi->update($data);
        return new ApiResource(true, 'Notifikasi Berhasil Diupdate', $notifikasi);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return new ApiResource(true, 'Notifikasi Berhasil Dihapus', null);
    }
}

