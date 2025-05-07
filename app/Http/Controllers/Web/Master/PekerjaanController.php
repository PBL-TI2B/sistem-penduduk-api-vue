<?php

namespace App\Http\Controllers\Web\Master;

use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/Pekerjaan/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Pekerjaan/Create');
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
    public function show(Pekerjaan $pekerjaan)
    {
        return Inertia::render('Master/Pekerjaan/Show', [
            'uuid' => $pekerjaan->uuid
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pekerjaan $pekerjaan)
    {
        return Inertia::render('Master/Pekerjaan/Edit', [
            'uuid'=>$pekerjaan->uuid
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pekerjaan $pekerjaan)
    {
        abort(404);
    }
}
