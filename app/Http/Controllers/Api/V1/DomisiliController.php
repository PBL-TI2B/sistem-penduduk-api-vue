<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domisili;
use App\Http\Resources\DomisiliResource;
use Illuminate\Support\Facades\Validator;

class DomisiliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = Domisili::with('penduduk', 'rt', 'rt.rw');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('status_tempat_tinggal', 'like', "%$search%")
              ->orWhereHas('penduduk', function ($q2) use ($search) {
                  $q2->where('nama_lengkap', 'like', "%$search%");
              });
        });
    }

    $domisili = $query->paginate($request->get('per_page', 10));
    $collection = DomisiliResource::collection($domisili->getCollection());
    $domisili->setCollection(collect($collection));

    return response()->json([
        'success' => true,
        'message' => 'Daftar Data Domisili',
        'data'    => $domisili,
    ]);
}

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'rt_id'       => 'required|exists:rt,id',
            'status_tempat_tinggal' => 'required|in:tetap,sementara',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $domisili = Domisili::create([
            'penduduk_id' => $request->penduduk_id,
            'rt_id'       => $request->rt_id,
            'status_tempat_tinggal' => $request->status_tempat_tinggal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Domisili Berhasil Ditambahkan',
            'data'    => new DomisiliResource($domisili->load('penduduk', 'rt', 'rt.rw',))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Domisili $domisili)
    {
        $domisili->load(['penduduk','rt', 'rt.rw',]);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Domisili',
            'data'    => new DomisiliResource($domisili->load('penduduk', 'rt.rw',))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Domisili $domisili)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduk,id',
            'rt_id'       => 'required|exists:rt,id',
            'status_tempat_tinggal' => 'required|in:tetap,sementara',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $domisili->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data Domisili Berhasil Diubah',
            'data'    => new DomisiliResource($domisili->load('penduduk', 'rt', 'rt.rw',))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domisili $domisili)
    {
        $domisili->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Domisili Berhasil Dihapus',
            'data'    => null
        ]);
    }

}
