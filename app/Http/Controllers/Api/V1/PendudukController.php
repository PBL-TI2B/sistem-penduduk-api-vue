<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Penduduk;
use App\Http\Controllers\Controller;
use App\Http\Resources\PendudukResource;
use App\Http\Resources\PaginatedResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::with(['pekerjaan', 'pendidikan'])->orderBy('status', 'asc');

        // Filter status hidup/mati
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Filter status perkawinan
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        // Filter pendidikan (jika nama ada di tabel relasi `pendidikan`)
        if ($request->filled('pendidikan')) {
            $query->whereHas('pendidikan', function ($q) use ($request) {
                $q->where('jenjang', $request->pendidikan); // sesuaikan nama kolom jika perlu
            });
        }
        // Filter agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        $penduduk = $query->paginate($request->get('per_page', 10));
        $collection = PendudukResource::collection($penduduk->getCollection());
        $penduduk->setCollection(collect($collection));

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data penduduk',
            'data' => $penduduk,
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:penduduk',
            'nama_lengkap' => 'required',
            'foto' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'agama' => 'required|in:Islam,Kristen,Katholik,Hindu,Buddha,Khonghucu',
            'status_perkawinan' => 'required|in:kawin,belum kawin',
            'tinggi_badan' => 'nullable',
            'status' => 'required|in:hidup,mati',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'pendidikan_id' => 'required|exists:pendidikan,id',
            'ibu_id' => 'nullable|exists:penduduk,id',
            'ayah_id' => 'nullable|exists:penduduk,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto = $request->file('foto');
        $foto->storeAs('penduduk', $foto->hashName());

        $penduduk = Penduduk::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'foto' => $foto->hashName(),
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'gol_darah' => $request->gol_darah,
            'status_perkawinan' => $request->status_perkawinan,
            'tinggi_badan' => $request->tinggi_badan,
            'status' => $request->status,
            'pekerjaan_id' => $request->pekerjaan_id,
            'pendidikan_id' => $request->pendidikan_id,
            'ibu_id' => $request->ibu_id,
            'ayah_id' => $request->ayah_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data penduduk',
            'data' => new PendudukResource($penduduk->load(['pekerjaan', 'pendidikan', 'domisili.rt.rw'])),
        ]);
    }

    public function show(Penduduk $penduduk)
    {
        // Panggil load untuk memuat semua relasi yang diperlukan
        $penduduk->load(['pekerjaan', 'pendidikan', 'domisili.rt.rw']);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil detail data penduduk',
            'data' => new PendudukResource($penduduk),
        ]);
    }


    public function update(Request $request, Penduduk $penduduk)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:penduduk,nik,' . $penduduk->id,
            'nama_lengkap' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'agama' => 'required|in:Islam,Kristen,Katholik,Hindu,Buddha,Khonghucu',
            'status_perkawinan' => 'required|in:kawin,belum kawin',
            'tinggi_badan' => 'nullable',
            'status' => 'required|in:hidup,mati',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'pendidikan_id' => 'required|exists:pendidikan,id',
            'ibu_id' => 'nullable|exists:penduduk,id',
            'ayah_id' => 'nullable|exists:penduduk,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            Storage::delete('penduduk/' . basename($penduduk->foto));

            $foto = $request->file('foto');
            $foto->storeAs('penduduk', $foto->hashName());

            $data['foto'] = $foto->hashName();
        } else {
            $data['foto'] = $penduduk->foto;
        }

        $penduduk->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ubah data penduduk',
            'data' => new PendudukResource($penduduk->load(['pekerjaan', 'pendidikan', 'domisili.rt.rw'])),
        ]);
    }

    public function destroy(Penduduk $penduduk)
    {
        Storage::delete('penduduk/' . basename($penduduk->foto));
        $penduduk->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil hapus data penduduk',
            'data' => null,
        ]);
    }

    public function getFoto($filename, Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $path = storage_path('app/private/penduduk/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return response()->file($path);
    }

    public function exportPdf()
    {
        $penduduk = Penduduk::with(['pekerjaan', 'pendidikan'])->get();

        $pdf = Pdf::loadView('exports.penduduk', compact('penduduk'));
        return $pdf->download('penduduk.pdf');
    }

    public function exportExcel()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="penduduk.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // Tambah BOM UTF-8
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Pakai delimiter ;
            fputcsv($handle, ['Nama', 'NIK', 'Tanggal Lahir'], ';');

            foreach (Penduduk::all() as $data) {
                fputcsv($handle, [
                    $data->nama_lengkap,
                    $data->nik,
                    $data->tanggal_lahir,
                ], ';');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
