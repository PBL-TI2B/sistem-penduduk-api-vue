<?php

namespace App\Http\Controllers\Web\Master;

use App\Models\Pendidikan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/Pendidikan/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Pendidikan/Create');
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
    public function show(Pendidikan $pendidikan)
    {
        return Inertia::render('Master/Pendidikan/Show', [
            'uuid'=>$pendidikan->uuid
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendidikan $pendidikan)
    {
        return Inertia::render('Master/Pendidikan/Edit', [
            'uuid'=>$pendidikan->uuid
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
