<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotifikasiResource;
use Illuminate\Support\Facades\Validator;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::with('user')->paginate(10);
        $collection = NotifikasiResource::collection($notifikasi->getCollection());
        $notifikasi->setCollection(collect($collection));

        return response()->json([
            'success' => true,
            'message' => 'Daftar Notifikasi',
            'data' => $notifikasi,
        ]);
    }

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

        $notifikasi = Notifikasi::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi Berhasil Ditambahkan',
            'data' => new NotifikasiResource($notifikasi->load('user')),
        ]);
    }

    public function show(Notifikasi $notifikasi)
    {
        $notifikasi->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Detail Notifikasi',
            'data' => new NotifikasiResource($notifikasi),
        ]);

    }

    public function update(Request $request, Notifikasi $notifikasi)
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

        $notifikasi->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi Berhasil Diperbarui',
            'data' => new NotifikasiResource($notifikasi->load('user')),
        ]);
    }

    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi Berhasil Dihapus',
            'data' => null,
        ]);
    }
}