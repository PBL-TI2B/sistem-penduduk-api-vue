<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Kematian;
use App\Models\Penduduk;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KematianController extends Controller
{
    public function index(Request $request)
    {
        $query = Kematian::with('penduduk');

         if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('penduduk', function ($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', "%$search%");
                })
                ->orWhere('sebab_kematian', 'like', "%$search%");
            });
        }

        $kematian = $query->paginate($request->get('per_page', 10));
        //$kematian->setCollection(collect(KematianResource::collection($kematian->getCollection())));

        return new ApiResource(true, 'Daftar Data Kematian', $kematian);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_kematian' => 'required|date',
            'sebab_kematian' => 'required',
            'penduduk_id' => 'nullable|exists:penduduk,id'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kematian = Kematian::create([
            'tanggal_kematian' => $request->tanggal_kematian,
            'sebab_kematian' => $request->sebab_kematian,
            'penduduk_id' => $request->penduduk_id,
        ]);

        if ($request->penduduk_id) {
            Penduduk::where('id', $request->penduduk_id)->update(['status' => 'mati']);
        }

        return new ApiResource(true, 'Data Kematian Berhasil Ditambahkan', $kematian);
    }

    public function show(Kematian $kematian): ApiResource
    {
        return new ApiResource(true, 'Detail Data Kematian', $kematian);
    }

    public function update(Request $request, Kematian $kematian)
    {
        $validator = Validator::make($request->all(),[
            'tanggal_kematian' => 'required|date',
            'sebab_kematian' => 'required',
            'penduduk_id' => 'nullable|exists:penduduk,id'
        ]);

        $data = $request->all();

        $kematian->update($data);
        if ($request->penduduk_id) {
            Penduduk::where('id', $request->penduduk_id)->update(['status' => 'mati']);
        }        

        return new ApiResource(true, 'Data Kematian Berhasil Diubah', $kematian);
    }

    public function destroy(Kematian $kematian)
    {
        $kematian->delete();
        if ($kematian->penduduk_id) {
            Penduduk::where('id', $kematian->penduduk_id)->update(['status' => 'hidup']);
        }
        return new ApiResource(true, 'Data Kematian Berhasil Dihapus', null);
    }
}
