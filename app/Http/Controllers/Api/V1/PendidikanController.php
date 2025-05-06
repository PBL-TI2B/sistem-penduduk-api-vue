<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Pendidikan;
use Illuminate\Support\Facades\Validator;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendidikan = Pendidikan::paginate(10);
        return new ApiResource(true, 'Daftar Data Pendidikan', $pendidikan);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenjang' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pendidikan = Pendidikan::create([
            'jenjang' => $request->jenjang,
        ]);

        return new ApiResource(true, 'Data Pendidikan Baru Berhasil Ditambahkan', $pendidikan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendidikan $pendidikan)
    {
        $pendidikan->load('penduduk');
        return new ApiResource(true, 'Detail Data Pendidikan', $pendidikan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendidikan $pendidikan)
    {
        $validator = Validator::make($request->all(), [
            'jenjang' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $pendidikan->update($data);

        return new ApiResource(true, 'Data Pendidikan Berhasil Diubah', $pendidikan);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendidikan $pendidikan)
    {
        $pendidikan->delete();
        return new ApiResource(true, 'Data Pendidikan Berhasil Dihapus', null);
    }

}
