<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\PekerjaanResource;
use App\Models\Pekerjaan;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PekerjaanController extends Controller
{
    public function index(Request $request)
    {
    
        $perPage = $request->input('per_page', 10);
        $query = Pekerjaan::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_pekerjaan', 'like', "%$search%");
        }
        
        $pekerjaan = $query->withCount('penduduk')->paginate($perPage);
        //$collection = PekerjaanResource::collection($pekerjaan->getCollection());
        //$pekerjaan->setCollection(collect($collection));
        
        return new ApiResource(true, 'Daftar Pekerjaan', $pekerjaan);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $pekerjaan = Pekerjaan::create($request->all());

        return new ApiResource(true, 'Daftar Pekerjaan', $pekerjaan);
    }

    public function show(Pekerjaan $pekerjaan)
    {
        return new ApiResource(true, 'Daftar Pekerjaan', $pekerjaan);
    }

    public function update(Request $request, Pekerjaan $pekerjaan) 
    {
        $validator = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required' 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $pekerjaan->update($data);

        return new ApiResource(true, 'Daftar Pekerjaan', $pekerjaan);
    }

    public function destroy(Pekerjaan $pekerjaan)
    {
        $pekerjaan->delete();
        return new ApiResource(true, 'Daftar Pekerjaan Berhasil Dihapus', null);
    }

    public function exportPdf()
    {
        $pekerjaan = Pekerjaan::get();
        $pdf = \PDF::loadView('exports.pekerjaan', compact('pekerjaan'));
        return $pdf->download('pekerjaan.pdf');
    }
}
