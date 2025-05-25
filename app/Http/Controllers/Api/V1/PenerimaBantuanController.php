<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenerimaBantuan;
use App\Http\Resources\PenerimaBantuanResource;
use Illuminate\Support\Facades\Validator;

class PenerimaBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penerimaBantuan = PenerimaBantuan::with(['bantuan.kategoriBantuan', 'kurangMampu'])->paginate(10);
        $collection = PenerimaBantuanResource::collection($penerimaBantuan->getCollection());
        $penerimaBantuan->setCollection(collect($collection));
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Penerima Bantuan',
            'data'    => $penerimaBantuan,
        ]);
    }

    // $table->timestamps();
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:aktif,selesai,ditolak',
            'tanggal_penerimaan' => 'required|date',
            'keterangan' => 'nullable|string',
            'kurang_mampu_id' => 'required|exists:kurang_mampu,id',
            'bantuan_id' => 'required|exists:bantuan,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $penerimaBantuan = PenerimaBantuan::create([
            'status' => $request->status,
            'tanggal_penerimaan' => $request->tanggal_penerimaan,
            'keterangan' => $request->keterangan,
            'kurang_mampu_id' => $request->kurang_mampu_id,
            'bantuan_id' => $request->bantuan_id,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Penerima Bantuan Berhasil Ditambahkan',
            'data'    => new PenerimaBantuanResource($penerimaBantuan->load(['bantuan.kategoriBantuan', 'kurangMampu']))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaBantuan $penerimaBantuan)
    {
        $penerimaBantuan->load(['bantuan.kategoriBantuan', 'kurangMampu']);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Penerima Bantuan',
            'data'    => new PenerimaBantuanResource($penerimaBantuan)
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaBantuan $penerimaBantuan, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:aktif,selesai,ditolak',
            'tanggal_penerimaan' => 'required|date',
            'keterangan' => 'nullable|string',
            'kurang_mampu_id' => 'required|exists:kurang_mampu,id',
            'bantuan_id' => 'required|exists:bantuan,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $penerimaBantuan->update([
            'status' => $request->status,
            'tanggal_penerimaan' => $request->tanggal_penerimaan,
            'keterangan' => $request->keterangan,
            'kurang_mampu_id' => $request->kurang_mampu_id,
            'bantuan_id' => $request->bantuan_id,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Penerima Bantuan Berhasil Diubah',
            'data'    => new PenerimaBantuanResource($penerimaBantuan->load(['kurangMampu', 'bantuan', 'bantuan.kategoriBantuan', 'kurangMampu.anggota_keluarga', 'kurangMampu.anggota_keluarga.penduduk']))
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaBantuan $penerimaBantuan)
    {
        $penerimaBantuan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Penerima Bantuan Berhasil Dihapus',
            'data'    => null,
        ]);
    }
}
