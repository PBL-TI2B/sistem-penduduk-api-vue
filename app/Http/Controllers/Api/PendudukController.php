<?php

namespace App\Http\Controllers\Api;

use App\Models\Penduduk;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::with(['pekerjaan', 'pendidikan', 'ayah', 'ibu'])->paginate(10);
        return new ApiResource(true, 'Daftar Data Penduduk', $penduduk);
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

        return new ApiResource(true, 'Data Penduduk Berhasil Ditambahkan', $penduduk);
    }

    public function show(Penduduk $penduduk)
    {
        return new ApiResource(true, 'Detail Data Penduduk', $penduduk);
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

        return new ApiResource(true, 'Data Penduduk Berhasil Diubah', $penduduk);
    }

    public function destroy(Penduduk $penduduk)
    {
        Storage::delete('penduduk/' . basename($penduduk->foto));
        $penduduk->delete();
        return new ApiResource(true, 'Data Penduduk Berhasil Dihapus', null);
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
}
