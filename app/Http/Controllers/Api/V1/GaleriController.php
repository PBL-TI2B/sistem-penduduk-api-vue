<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Http\Resources\GaleriResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeri = Galeri::with('user')->paginate(10);
        $collection = GaleriResource::collection($galeri->getCollection());
        $galeri->setCollection(collect($collection));
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Galeri',
            'data'    => $galeri,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'slug' => 'required|unique:galeri',
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'deskripsi' => 'nullable',
            'tanggal_post' => 'required|date',
            'url_media' => 'required|url',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $thumbnail = $request->file('thumbnail');
        $thumbnail->storeAs('galeri', $thumbnail->hashName());
        $galeri = Galeri::create([
            'judul' => $request->judul,
            'slug' => $request->slug,
            'thumbnail' => $thumbnail->hashName(),
            'deskripsi' => $request->deskripsi,
            'tanggal_post' => $request->tanggal_post,
            'url_media' => $request->url_media,
            'user_id' => $request->user_id,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Galeri Berhasil Ditambahkan',
            'data'    => new GaleriResource($galeri->load('user'))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        $galeri->load(['user']);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Galeri',
            'data'    => new GaleriResource($galeri->load('user'))
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri, )
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'slug' => 'required|unique:galeri,slug,' . $galeri->id,
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'deskripsi' => 'nullable',
            'tanggal_post' => 'required|date',
            'url_media' => 'required|url',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $request->except('thumbnail');
        if ($request->hasfile('thumbnail')) {
            Storage::delete('galeri/' . basename($galeri->thumbnail));
            $thumbnail = $request->file('thumbnail');
            $thumbnail->storeAs('galeri', $thumbnail->hashName());
            $data['thumbnail'] = $thumbnail->hashName();
        }else {
            $data['thumbnail'] = $galeri->thumbnail;
        }
        $galeri->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Data Galeri Berhasil Diubah',
            'data'    => new GaleriResource($galeri->load('user'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        Storage::delete('galeri/' . basename($galeri->thumbnail));
        $galeri->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Galeri Berhasil Dihapus',
            'data'    => null
        ]);
    }

    public function getGaleri($filename, Request $request) 
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $path = storage_path('app/private/galeri/' . $filename);
    
        if (!file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }
    
        return response()->file($path);
    }
}
