<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Berita;
use App\Http\Controllers\Controller;
use App\Http\Resources\BeritaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Berita::with('user');
        // ->where('status', 'publish');

        // Fitur pencarian (search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('konten', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Tambahkan filter arah urutan
        $orderDir = $request->get('order_dir', 'desc'); // default desc
        $query->orderBy('published_at', $orderDir);

        $berita = $query->paginate($request->get('per_page', 10));

        // Format resource
        $collection = BeritaResource::collection($berita->getCollection());
        $berita->setCollection(collect($collection));

        // Respon JSON
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Berita',
            'data' => $berita,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'judul' => 'required',
            // Hapus validasi slug dari sini
            'konten' => 'required',
            'jumlah_dilihat' => 'required|integer',
            'status' => 'required|in:draft,publish',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $thumbnail = $request->file('thumbnail');
        $thumbnail->storeAs('berita', $thumbnail->hashName(), 'public');

        $slug = Str::slug($request->judul);

        // Pastikan slug unik
        $originalSlug = $slug;
        $i = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        $berita = Berita::create([
            'thumbnail' => $thumbnail->hashName(),
            'judul' => $request->judul,
            'slug' => $slug,
            'konten' => $request->konten,
            'jumlah_dilihat' => $request->input('jumlah_dilihat', 0),
            'status' => $request->input('status', 'draft'),
            'published_at' => $request->input('status') === 'publish' ? now() : null,
            'user_id' => $request->user_id,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Berita Berhasil Ditambahkan',
            'data' => new BeritaResource($berita->load('user')),
        ]);
    }

    public function show(Berita $berita)
    {
        // $berita = $berita->load('user');

        // if ($berita->status === 'publish') {
        //     $berita->increment('jumlah_dilihat');
        // }

        $user = auth('sanctum')->user(); // Bisa null jika guest
        $role = null;

        if ($user) {
            // Jika pakai Spatie
            $role = $user->getRoleNames()->first();
        }

        // Increment hanya jika:
        // - status publish
        // - (guest ATAU user login tapi bukan superadmin/admin)
        if (
            $berita->status === 'publish' &&
            (
                !$role // guest
                || !in_array($role, ['superadmin', 'admin'])
            )
        ) {
            $berita->increment('jumlah_dilihat');
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Berita',
            'data' => new BeritaResource($berita->load('user')),
        ]);
    }

    public function update(Request $request, Berita $berita)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'judul' => 'required',
            // Hapus validasi slug dari sini
            'konten' => 'required',
            'jumlah_dilihat' => 'default:0',
            'status' => 'required|in:draft,publish',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('thumbnail');

        // Generate slug dari judul
        $slug = Str::slug($request->judul);
        $originalSlug = $slug;
        $i = 1;
        while (Berita::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }
        $data['slug'] = $slug;

        if ($request->hasfile('thumbnail')) {
            Storage::delete('berita/' . $berita->thumbnail);
            $thumbnail = $request->file('thumbnail');
            $thumbnail->storeAs('berita', $thumbnail->hashName(), 'public');

            $data['thumbnail'] = $thumbnail->hashName();
        } else {
            $data['thumbnail'] = $berita->thumbnail;
        }

        // Logika published_at
        if ($berita->published_at) {
            // Jika sudah pernah publish, jangan ubah published_at
            $data['published_at'] = $berita->published_at;
        } else {
            // Jika dari draft ke publish, isi published_at
            if ($request->input('status') === 'publish') {
                $data['published_at'] = now();
            } else {
                $data['published_at'] = null;
            }
        }

        $berita->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Data Berita Berhasil Diubah',
            'data' => new BeritaResource($berita->load('user')),
        ]);
    }

    public function destroy(Berita $berita)
    {
        Storage::delete('berita/' . basename($berita->thumbnail));
        $berita->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berita Berhasil Dihapus',
            'data' => null
        ]);
    }

    public function getBerita($filename, Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $path = storage_path('app/private/berita/' . $filename);
        if (!file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->file($path);
    }
}