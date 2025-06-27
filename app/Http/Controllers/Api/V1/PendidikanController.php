<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendidikan;
use App\Http\Resources\PendidikanResource;
use Illuminate\Support\Facades\Validator;

class PendidikanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendidikan::query(); 

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('jenjang', 'like', "%{$search}%");
        }

        if ($request->filled('jenjang')) {
            $jenjang = $request->jenjang;
            $query->where('jenjang', $jenjang);
        }

        $pendidikan = $query->paginate($request->get('per_page', 10));

        $collection = PendidikanResource::collection($pendidikan->getCollection());
        $pendidikan->setCollection(collect($collection));

        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Pendidikan',
            'data'    => $pendidikan,
        ]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenjang' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pendidikan = Pendidikan::create([
            'jenjang' => $request->jenjang,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Pendidikan Baru Berhasil Ditambahkan',
            'data'    => new PendidikanResource($pendidikan->load('penduduk'))
        ]);
    }

    public function show(Pendidikan $pendidikan)
    {
        $pendidikan->load('penduduk');
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pendidikan',
            'data'    => new PendidikanResource($pendidikan->load('penduduk'))
        ]);
    }
  
    public function update(Request $request, Pendidikan $pendidikan)
    {
        $validator = Validator::make($request->all(), [
            'jenjang' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pendidikan->update([
            'jenjang' => $request->jenjang,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Pendidikan Berhasil Diupdate',
            'data'    => new PendidikanResource($pendidikan->load('penduduk'))
        ]);
    }

    public function destroy(Pendidikan $pendidikan)
    {
        $pendidikan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Pendidikan Berhasil Dihapus',
            'data'    => null
        ]);
    }

    public function exportPdf()
    {
        $pendidikan = Pendidikan::get();
        $pdf = PDF::loadView('exports.pendidikan', compact('pendidikan'));
        return $pdf->download('pendidikan.pdf');
    }
}
