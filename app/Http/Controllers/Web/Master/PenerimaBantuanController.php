<?php

namespace App\Http\Controllers\Web\Master;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\PenerimaBantuan;
use Illuminate\Http\Request;

class PenerimaBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/PenerimaBantuan/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/PenerimaBantuan/Create');
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
    public function show(PenerimaBantuan $penerimaBantuan)
    {
        return Inertia::render('Master/PenerimaBantuan/Show', [
            'uuid' => $penerimaBantuan->uuid
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenerimaBantuan $penerimaBantuan)
    {
        return Inertia::render('Master/PenerimaBantuan/Edit', [
            'uuid' => $penerimaBantuan->uuid
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenerimaBantuan $penerimaBantuan)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaBantuan $penerimaBantuan)
    {
        abort(404);
    }
}
