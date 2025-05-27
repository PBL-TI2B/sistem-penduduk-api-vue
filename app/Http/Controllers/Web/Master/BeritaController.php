<?php

namespace App\Http\Controllers\Web\Master;

use App\Models\Berita;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/Berita/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Berita/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita_admin)
    {
        return Inertia::render('Master/Berita/Show', [
            'uuid' => $berita_admin->uuid
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita_admin)
    {
        return Inertia::render('Master/Berita/Edit', [
            'uuid' => $berita_admin->uuid
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
