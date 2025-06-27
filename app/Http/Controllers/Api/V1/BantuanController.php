<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Bantuan;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Http\Resources\BantuanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class BantuanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        // $query = Bantuan::withCount(['kategoriBantuan', 'penerimaBantuan']);
        $query = Bantuan::query();

        // General search across main columns
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->Where('nama_bantuan', 'like', "%$search%")
                    ->orWhere('nominal', 'like', "%$search%")
                    ->orWhere('periode', 'like', "%$search%")
                    ->orWhere('lama_periode', 'like', "%$search%")
                    ->orWhere('instansi', 'like', "%$search%")
                    // ->orWhere('keterangan', 'like', "%$search%")
                ;
            });
        }

        // Filtering
        if ($request->filled('kategori_bantuan_id')) {
            $query->where('kategori_bantuan_id', $request->kategori_bantuan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //! Tambahkan eager loading untuk kategoriBantuan, menghindari N+1 query
        // $data = $query->withCount('penerimaBantuan')->paginate($perPage);
        $data = $query->with(['kategoriBantuan'])->withCount('penerimaBantuan')->paginate($perPage);
        $collection = BantuanResource::collection($data->getCollection());
        $data->setCollection(collect($collection));

        return new ApiResource(true, 'Daftar Bantuan', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bantuan' => 'required|string|max:50',
            'kategori_bantuan_id' => 'required|exists:kategori_bantuan,id',
            'status' => 'nullable|in:aktif,nonaktif',
            'nominal' => 'nullable|string|max:50',
            'periode' => 'required|string|max:50',
            'lama_periode' => 'required|string|max:50',
            'instansi' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        if (!isset($data['status'])) {
            $data['status'] = 'nonaktif';
        }
        $bantuan = Bantuan::create($data);
        $bantuan->load('kategoriBantuan');

        return new ApiResource(true, 'Data Bantuan Berhasil Ditambahkan', new BantuanResource($bantuan));
    }

    public function show(Bantuan $bantuan)
    {
        $bantuan->load('kategoriBantuan');
        $bantuan->loadCount('penerimaBantuan');

        return new ApiResource(true, 'Detail Data Bantuan', new BantuanResource($bantuan));
    }

    public function update(Request $request, Bantuan $bantuan)
    {
        $bantuan->loadCount('penerimaBantuan');

        // Jika request HANYA untuk mengubah status
        if ($request->has('status')) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:aktif,nonaktif',
            ]);
            $message = 'Status berhasil diubah.';
        } else {
            // Guard clause untuk pembaruan data lengkap
            $isActive = $bantuan->status === 'aktif';
            $hasRecipients = $bantuan->penerima_bantuan_count > 0;

            if ($isActive && $hasRecipients) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat memperbarui bantuan yang sedang aktif dan sudah memiliki penerima.',
                ], 403);
            }

            if ($isActive) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat memperbarui bantuan yang sedang aktif. Harap nonaktifkan bantuan terlebih dahulu jika ingin mengubah data.',
                ], 403);
            }

            if ($hasRecipients) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat memperbarui bantuan yang sudah memiliki penerima.',
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'nama_bantuan' => 'required|string|max:50',
                'kategori_bantuan_id' => 'required|exists:kategori_bantuan,id',
                'nominal' => 'nullable|string|max:50',
                'periode' => 'required|string|max:50',
                'lama_periode' => 'required|string|max:50',
                'instansi' => 'required|string|max:50',
                'keterangan' => 'nullable|string',
            ]);
            $message = 'Data bantuan berhasil diubah.';
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $bantuan->update($validator->validated());
        $bantuan->load('kategoriBantuan');

        return new ApiResource(true,  $message, new BantuanResource($bantuan));
    }

    public function destroy(Bantuan $bantuan)
    {
        $bantuan->loadCount('penerimaBantuan');
        if ($bantuan->status !== 'nonaktif' && $bantuan->penerima_bantuan_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data hanya dapat dihapus jika status nonaktif atau belum memiliki penerima.',
            ], 403);
        }
        $bantuan->delete();
        return new ApiResource(true, 'Data Bantuan Berhasil Dihapus', null);
    }

    public function exportPdf()
    {
        $bantuan = Bantuan::with(['kategoriBantuan'])->get();
        $pdf = Pdf::loadView('exports.bantuan', compact('bantuan'));
        return $pdf->download('bantuan.pdf');
    }

    public function exportExcel()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="bantuan.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // Tambah BOM UTF-8
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Pakai delimiter ;
            fputcsv($handle, ['Nama Bantuan', 'Kategori', 'Nominal', 'Periode', 'Lama Periode', 'Instansi', 'Keterangan'], ';');

            foreach (Bantuan::all() as $data) {
                fputcsv($handle, [
                    $data->nama_bantuan,
                    $data->kategoriBantuan->kategori,
                    $data->nominal,
                    $data->periode,
                    $data->lama_periode,
                    $data->instansi,
                    $data->keterangan,
                ], ';');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}