<?php

namespace App\Http\Controllers\Api;

use App\Models\Berita;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita= Berita::with('users')->paginate(10);
        return new ApiResource(true, 'Daftar Data Berita', $berita);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'judul' => 'required',
            'slug' => 'required|unique:berita',
            'konten' => 'required',
            'tanggal_post' => 'required|date',
            'jumlah_dilihat' => 'required|integer',
            'status' => 'required|in:draft,publish',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $thumbnail = $request->file('thumbnail');
        $thumbnail->storeAs('berita', $thumbnail->hashName());

        $berita = Berita::create([
            'thumbnail' => $thumbnail->hashName(),
            'judul' => $request->judul,
            'slug' => $request->slug,
            'konten' => $request->konten,
            'tanggal_post' => $request->tanggal_post,
            'jumlah_dilihat' => $request->input('jumlah_dilihat', 0),
            'status' => $request->input('status', 'draft'),
            'user_id' => $request->user_id,
        ]);
        return new ApiResource(true, 'Berita Berhasil Ditambahkan', $berita);
    }
    public function show(Berita $berita)
    {
        return new ApiResource(true, 'Detail Data Berita', $berita);
    }

    public function update(Request $request, Berita $berita)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'judul' => 'required',
            'slug' => 'required|unique:berita,slug,' . $berita->id,
            'konten' => 'required',
            'tanggal_post' => 'required|date',
            'jumlah_dilihat' => 'default:0',
            'status' => 'required|in:draft,publish|default:draft',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('thumbnail');

        if ($request->hasfile('thumbnail')) {
            Storage::delete('berita/' . $berita->thumbnail);
            $thumbnail = $request->file('thumbnail');
            $thumbnail->storeAs('berita', $thumbnail->hashName());

            $data['thumbnail'] = $thumbnail->hashName();
        } else {
            $data['thumbnail'] = $berita->thumbnail;
        }

        $berita->update($data);
        return new ApiResource(true, 'Berita Berhasil Diupdate', $berita);
    }

    public function destroy(Berita $berita)
    {
        Storage::delete('berita/' . basename($berita->thumbnail));
        $berita->delete();
        return new ApiResource(true, 'Berita Berhasil Dihapus', null);
    }
}
