<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Jabatan;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $jabatan = Jabatan::paginate($perPage);
        return new ApiResource(true, 'Daftar Data Jabatan', $jabatan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jabatan' => 'required',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jabatan = Jabatan::create([
            'jabatan' => $request->jabatan,
            'keterangan' => $request->keterangan,
        ]);

        return new ApiResource(true, 'Data Jabatan Baru Berhasil Ditambahkan', $jabatan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        return new ApiResource(true, 'Detail Data Jabatan', $jabatan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $validator = Validator::make($request->all(), [
            'jabatan' => 'required',
            'keterangan' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $jabatan->update($data);

        return new ApiResource(true, 'Data Jabatan Berhasil Diubah', $jabatan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return new ApiResource(true, 'Data Jabatan Berhasil Dihapus', null);
    }
}
