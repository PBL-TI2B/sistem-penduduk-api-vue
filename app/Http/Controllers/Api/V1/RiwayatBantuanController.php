<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\RiwayatBantuan;
use App\Http\Resources\RiwayatBantuanResource;
use Illuminate\Support\Facades\Validator;

class RiwayatBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $query = RiwayatBantuan::query();

        //! Filter Search
        // if ($request->filled('search')) {
        //     $search = $request->search;

        //     $query->where(function ($query) use ($search) {
        //         // Cari di penduduk (nama_lengkap, nik)
        //         $query->whereHas('kurangMampu.anggotaKeluarga.penduduk', function ($q) use ($search) {
        //             $q->where('nama_lengkap', 'like', "%$search%")
        //                 ->orWhere('nik', 'like', "%$search%");
        //         })

        //             // Cari di relasi bantuan
        //             ->orWhereHas('bantuan', function ($q) use ($search) {
        //                 $q->where('nama_bantuan', 'like', "%$search%");
        //             });
        //     });
        // }

        //! Filter berdasarkan penerima_bantuan_id
        if ($request->filled('penerima_bantuan_id')) {
            $query->where('penerima_bantuan_id', $request->penerima_bantuan_id);
        } else {
            return new ApiResource(false, 'Harus mencantumkan id penerima bantuan', []); // Return empty if no penerima_bantuan_id is provided
        }

        // $data = $query->with(['bantuan.kategoriBantuan', 'kurangMampu.anggotaKeluarga.penduduk'])->paginate($perPage);
        $data = $query->paginate($perPage);
        $collection = RiwayatBantuanResource::collection($data->getCollection());
        $data->setCollection(collect($collection));

        return new ApiResource(true, 'Daftar Data Riwayat Bantuan', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RiwayatBantuan $riwayatBantuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatBantuan $riwayatBantuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatBantuan $riwayatBantuan)
    {
        //
    }
}
