<?php

namespace App\Http\Controllers\Web\Master;

use App\Http\Controllers\Controller;
use App\Models\Kematian;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KematianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/Kematian/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Kematian/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404); // Ganti nanti dengan logic penyimpanan
    }

    /**
     * Display the specified resource.
     */
    public function show(Kematian $kematian)
    {
        return Inertia::render('Master/Kematian/Show', [
            'uuid' => $kematian->uuid,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kematian $kematian)
    {
        return Inertia::render('Master/Kematian/Edit', [
            'uuid' => $kematian->uuid,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kematian $kematian)
    {
        abort(404); // Ganti nanti dengan logic update
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kematian $kematian)
    {
        abort(404); // Ganti nanti dengan logic delete
    }
}
