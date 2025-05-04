<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PindahanResource;
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

        $collection = PindahanResource::collection($pindahan->getCollection());
        $pindahan->setCollection(collect($collection));
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Pindahan',
            'data'    => $pindahan,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'status_pindahan' => 'required|in:masuk,keluar',
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

        return response()->json([
            'success' => true,
            'message' => 'Data Pindahan Berhasil Ditambahkan',
            'data'    => new PindahanResource($pindahan->load('penduduk'))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pindahan $pindahan)
    {
        $pindahan->load('penduduk');
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pindahan',
            'data'    => new PindahanResource($pindahan->load('penduduk'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pindahan $pindahan)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'status_pindahan' => 'required|in:masuk,keluar',
            'tanggal_pindahan'=> 'required|date',
            'alamat_asal_tujuan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $pindahan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data Pindahan Berhasil Diupdate',
            'data'    => new PindahanResource($pindahan->load('penduduk'))
        ]);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pindahan $pindahan)
    {
        $pindahan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Pindahan Berhasil Dihapus',
            'data'    => null
        ]);
    }
}
