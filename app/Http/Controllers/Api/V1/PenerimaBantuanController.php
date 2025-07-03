<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Bantuan;
use App\Http\Resources\ApiResource;
use App\Models\PenerimaBantuan;
use App\Models\KurangMampu;
use App\Http\Resources\PenerimaBantuanResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PenerimaBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $perPage = $request->input('per_page', 10);
        $query = PenerimaBantuan::query();

        //! Data Scoping berdasarkan Role
        //! Jika user adalah RT, tampilkan hanya warga di RT-nya
        if ($user->hasRole('rt')) {
            $rtId = $user->perangkatDesa?->rt_id;

            // Jika user RT tidak terhubung dengan data perangkat desa, kembalikan data kosong.
            if (!$rtId) {
                return new ApiResource(true, 'Daftar Data Kurang Mampu', KurangMampu::where('id', -1)->paginate($perPage));
            }

            $query->whereHas('kurangMampu.anggotaKeluarga.penduduk.domisili', function ($q) use ($rtId) {
                $q->where('rt_id', $rtId);
            });
        }

        //! Jika user adalah RW, tampilkan hanya warga di RW-nya
        if ($user->hasRole('rw')) {
            $rwId = $user->perangkatDesa?->rw_id;
            if ($rwId) {
                $query->whereHas('kurangMampu.anggotaKeluarga.penduduk.domisili.rt', function ($q) use ($rwId) {
                    $q->where('rw_id', $rwId);
                });
            }
        }

        //! Filter Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                // Cari di penduduk (nama_lengkap, nik)
                $query->whereHas('kurangMampu.anggotaKeluarga.penduduk', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%$search%")
                        ->orWhere('nik', 'like', "%$search%");
                })

                    // Cari di relasi bantuan
                    ->orWhereHas('bantuan', function ($q) use ($search) {
                        $q->where('nama_bantuan', 'like', "%$search%");
                    });
            });
        }

        //! Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->withCount('riwayatBantuan')->with(['bantuan.kategoriBantuan', 'kurangMampu.anggotaKeluarga.penduduk'])->paginate($perPage);
        // $data = $query->paginate($perPage);
        $collection = PenerimaBantuanResource::collection($data->getCollection());
        $data->setCollection(collect($collection));

        return new ApiResource(true, 'Daftar Data Penerima Bantuan', $data);
    }

    // $table->timestamps();
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kurang_mampu_id' => 'required|exists:kurang_mampu,id',
            'bantuan_id' => 'required|exists:bantuan,id',
            'tanggal_penerimaan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors(), 422);
        }

        // Ambil model induk
        $kurangMampu = KurangMampu::find($request->kurang_mampu_id);
        $bantuan = Bantuan::find($request->bantuan_id);

        // Cek status validasi pada tabel kurang_mampu
        if ($kurangMampu->status_validasi !== 'tervalidasi') {
            return new ApiResource(false, 'Penduduk yang dipilih harus berstatus "tervalidasi".', null, 422);
        }

        // Cek status pada tabel bantuan
        if ($bantuan->status !== 'aktif') {
            return new ApiResource(false, 'Bantuan yang dipilih harus berstatus "aktif".', null, 422);
        }

        // Cek kombinasi kurang_mampu_id dan bantuan_id sudah ada atau belum
        $exists = PenerimaBantuan::where('kurang_mampu_id', $request->kurang_mampu_id)
            ->where('bantuan_id', $request->bantuan_id)
            ->exists();

        if ($exists) {
            return new ApiResource(false, 'Data dengan Penduduk Kurang Mampu dan Bantuan yang sama sudah ada.', null, 409);
        }

        $tanggal_penerimaan = Carbon::parse($request->tanggal_penerimaan)->format('Y-m-d');

        $data = PenerimaBantuan::create([
            'kurang_mampu_id' => $request->kurang_mampu_id,
            'bantuan_id' => $request->bantuan_id,
            'status' => 'diajukan',
            'tanggal_penerimaan' => $tanggal_penerimaan,
            'keterangan' => $request->keterangan,
        ]);

        return new ApiResource(true, 'Data berhasil ditambahkan', new PenerimaBantuanResource($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaBantuan $penerimaBantuan)
    {

        $penerimaBantuan->load([
            'bantuan.kategoriBantuan',
            'kurangMampu.anggotaKeluarga.penduduk',
            // 'riwayatBantuan'
        ])->loadCount('riwayatBantuan');

        // $penerimaBantuan->loadCount('riwayatBantuan');
        return new ApiResource(true, 'Detail Data Penerima Bantuan', new PenerimaBantuanResource($penerimaBantuan));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PenerimaBantuan $penerimaBantuan, Request $request)
    {
        $riwayatBantuan = $penerimaBantuan->loadCount('riwayatBantuan');

        if ($riwayatBantuan->riwayat_bantuan_count > 0 && $request->input('status') === 'ditolak') {
            return new ApiResource(false, "Status tidak bisa diubah menjadi 'Ditolak' karena sudah pernah melakukan pencarian sebelumnya.", null, 403);
        }
        if ($request->has('status') && $penerimaBantuan->bantuan->status === 'nonaktif') {
            $validator = Validator::make(
                $request->all(),
                [
                    'status' => 'required|in:selesai,ditolak',
                ],
                [
                    'status.in' => 'Status hanya boleh diisi dengan "Selesai" atau "Ditolak" karena bantuan sudah nonaktif.',
                ]
            );
            $data = $request->only('status');
        } else if ($request->has('status')) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:aktif,selesai,ditolak',
            ]);
            $data = $request->only('status');
        } else {
            $validator = Validator::make($request->all(), [
                'keterangan' => 'nullable|string',
            ]);
            $data = $request->only('keterangan');
        }

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal, ' . $validator->errors()->first(), null, 422);
        }
        // $data = $request->only(['status', 'keterangan']);

        $penerimaBantuan->update($data);

        return new ApiResource(true, 'Data berhasil diperbarui', new PenerimaBantuanResource($penerimaBantuan));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaBantuan $penerimaBantuan)
    {
        $penerimaBantuan->loadCount('riwayatBantuan');
        if (
            $penerimaBantuan->status !== 'aktif'
            || $penerimaBantuan->riwayat_bantuan_count > 0
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Data hanya dapat dihapus jika status tidak aktif atau belum menerima pencairan bantuan.',
            ], 403);
        }
        $penerimaBantuan->delete();
        return new ApiResource(true, 'Data penerima bantuan berhasil dihapus', null);
    }

    public function exportPdf(Request $request)
    {
        // GANTI relasi 'penduduk' menjadi 'kurangMampu.anggotaKeluarga.penduduk'
        $query = PenerimaBantuan::query()->with(['kurangMampu.anggotaKeluarga.penduduk', 'bantuan']);

        if ($request->filled('search')) {
            $search = $request->search;
            // GANTI relasi 'penduduk' menjadi 'kurangMampu.anggotaKeluarga.penduduk'
            $query->whereHas('kurangMampu.anggotaKeluarga.penduduk', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
            });
        }
        if ($request->filled('status')) {
            // Ini sudah benar, nama kolom di tabel penerima_bantuan adalah 'status'
            $query->where('status', $request->status);
        }

        $penerimaBantuan = $query->get();
        $pdf = Pdf::loadView('exports.penerima-bantuan', compact('penerimaBantuan'));
        return $pdf->download('laporan-penerima-bantuan.pdf');
    }

    public function exportExcel(Request $request)
    {
        // 1. Definisikan variabel $headers di sini
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan-penerima-bantuan.csv"',
        ];

        // 2. Buat fungsi callback untuk menulis data
        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['Nama Lengkap', 'NIK', 'Nama Bantuan', 'Status', 'Tanggal Pengajuan'], ';');

            // Logika query yang sudah diperbaiki
            $query = PenerimaBantuan::query()->with(['kurangMampu.anggotaKeluarga.penduduk', 'bantuan']);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('kurangMampu.anggotaKeluarga.penduduk', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%$search%")
                        ->orWhere('nik', 'like', "%$search%");
                });
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $query->get()->each(function ($data) use ($handle) {
                $penduduk = optional(optional($data->kurangMampu)->anggotaKeluarga)->penduduk;

                fputcsv($handle, [
                    optional($penduduk)->nama_lengkap ?? 'Data Hilang',
                    "'" . (optional($penduduk)->nik ?? 'N/A'),
                    optional($data->bantuan)->nama_bantuan ?? 'Bantuan Dihapus',
                    $data->status,
                    \Carbon\Carbon::parse($data->created_at)->format('d-m-Y'),
                ], ';');
            });

            fclose($handle);
        };

        // 3. Kembalikan response stream dengan variabel $headers dan $callback
        return response()->stream($callback, 200, $headers);
    }
    /**
     * Fungsi untuk Ekspor Detail Penerima Bantuan + Riwayat (dari Show PenerimaBantuan)
     */
    public function exportDetailPdf(PenerimaBantuan $penerimaBantuan)
    {
        // Eager load necessary relations
        $penerimaBantuan->load([
            'kurangMampu.anggotaKeluarga.penduduk',
            'bantuan.kategoriBantuan',

        ])->loadCount('riwayatBantuan');

        return Pdf::loadView('exports.detail-penerima-bantuan', compact('penerimaBantuan'))
            ->download('detail-penerima-' . optional($penerimaBantuan->kurangMampu->anggotaKeluarga->penduduk)->nik . '.pdf');
    }
}