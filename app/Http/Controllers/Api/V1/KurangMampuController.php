<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\KurangMampu;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Http\Resources\KurangMampuResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KurangMampuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $perPage = $request->input('per_page', 10);
        $query = KurangMampu::query();

        //! Data Scoping berdasarkan Role
        //! Jika user adalah RT, tampilkan hanya warga di RT-nya
        if ($user->hasRole('rt')) {
            $rtId = $user->perangkatDesa?->rt_id;

            // Jika user RT tidak terhubung dengan data perangkat desa, kembalikan data kosong.
            if (!$rtId) {
                return new ApiResource(true, 'Daftar Data Kurang Mampu', KurangMampu::where('id', -1)->paginate($perPage));
            }

            $query->whereHas('anggotaKeluarga.penduduk.domisili', function ($q) use ($rtId) {
                $q->where('rt_id', $rtId);
            });
        }

        //! Jika user adalah RW, tampilkan hanya warga di RW-nya
        if ($user->hasRole('rw')) {
            $rwId = $user->perangkatDesa?->rw_id;
            if ($rwId) {
                $query->whereHas('anggotaKeluarga.penduduk.domisili.rt', function ($q) use ($rwId) {
                    $q->where('rw_id', $rwId);
                });
            }
        }

        //! Filter Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                // Cari di penduduk (nama_lengkap, nik)
                $query->whereHas('anggotaKeluarga.penduduk', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%$search%")
                        ->orWhere('nik', 'like', "%$search%");
                })

                    // Cari di relasi pekerjaan
                    ->orWhereHas('anggotaKeluarga.penduduk.pekerjaan', function ($q) use ($search) {
                        $q->where('nama_pekerjaan', 'like', "%$search%");
                    })

                    // Cari di relasi pendidikan
                    ->orWhereHas('anggotaKeluarga.penduduk.pendidikan', function ($q) use ($search) {
                        $q->where('jenjang', 'like', "%$search%");
                    });
            });
        }

        //! RENCANA - Tambahkan filter berdasarkan PENDAPATAN PER-HARI & PER-BULAN

        //! Filter berdasarkan status_validasi
        if ($request->filled('status_validasi')) {
            $query->where('status_validasi', $request->status_validasi);
        }

        $data = $query->withCount('penerimaBantuan')->paginate($perPage);
        $collection = KurangMampuResource::collection($data->getCollection());
        $data->setCollection(collect($collection));

        return new ApiResource(true, 'Daftar Data Kurang Mampu', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pendapatan_per_hari' => 'nullable|string',
                'pendapatan_per_bulan' => 'nullable|string',
                'jumlah_tanggungan' => 'nullable|string',
                'keterangan' => 'nullable|string',
                'anggota_keluarga_id' => 'required|exists:anggota_keluarga,id|unique:kurang_mampu,anggota_keluarga_id'
            ],
            [
                'anggota_keluarga_id.required' => 'Penduduk harus dipilih.',
                'anggota_keluarga_id.unique' => 'Penduduk yang dipilih sudah terdaftar sebagai Kurang Mampu.',
            ]
        );

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal, ' . $validator->errors()->first(), null, 422);
        }

        $dataToCreate = $validator->validated();
        $dataToCreate['status_validasi'] = 'belum tervalidasi';
        $dataToCreate['jumlah_tanggungan'] = $dataToCreate['jumlah_tanggungan'] ?? 0;

        $kurangMampu = KurangMampu::create($dataToCreate);

        return new ApiResource(true, 'Data Kurang Mampu Berhasil Ditambahkan', new KurangMampuResource($kurangMampu), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KurangMampu $kurangMampu)
    {
        return new ApiResource(true, 'Detail Data Kurang Mampu', new KurangMampuResource($kurangMampu));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KurangMampu $kurangMampu)
    {
        $user = $request->user();
        $message = 'Data Kurang Mampu berhasil diubah.';

        // Jika status sudah tervalidasi, tidak boleh mengubah data apapun
        if ($kurangMampu->status_validasi === 'tervalidasi') {
            return new ApiResource(false, 'Data tidak dapat diubah karena status sudah tervalidasi.', null, 403);
        }

        // Aturan validasi dasar yang bisa diubah oleh semua role yang berwenang
        $rules = [
            'pendapatan_per_hari' => 'nullable|string',
            'pendapatan_per_bulan' => 'nullable|string',
            'jumlah_tanggungan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ];

        //! Logika untuk role Admin dan Superadmin
        if ($user->hasAnyRole(['admin', 'superadmin']) && $request->has('status_validasi')) {
            $rules['status_validasi'] = 'required|in:tervalidasi,ditolak';
            $message = 'Status validasi berhasil diubah.';

            //! Jika role selain admin mencoba mengubah status, tolak.
        } elseif ($request->has('status_validasi')) {
            return new ApiResource(false, 'Anda tidak memiliki izin untuk mengubah status validasi.', null, 403);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal: ' . $validator->errors()->first(), null, 422);
        }

        // Update hanya data yang divalidasi untuk mencegah pembaruan field yang tidak diizinkan
        $kurangMampu->update($validator->validated());

        return new ApiResource(true, $message, new KurangMampuResource($kurangMampu));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KurangMampu $kurangMampu)
    {
        $kurangMampu->delete();
        return new ApiResource(true, 'Data Kurang Mampu Berhasil Dihapus', null);
    }

    public function exportPdf()
    {
        $kurangMampu = KurangMampu::get();
        $pdf = Pdf::loadView('exports.kurang-mampu', compact('kurangMampu'));
        return $pdf->download('kurang-mampu.pdf');
    }
}