<?php

namespace App\Http\Controllers\Web\Master;

use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/Bantuan/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Bantuan/Create');
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
    public function show(Bantuan $bantuan)
    {
        return Inertia::render('Master/Bantuan/Show', [
            'uuid' => $bantuan->uuid
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bantuan $bantuan)
    {
        return Inertia::render('Master/Bantuan/Edit', [
            'uuid' => $bantuan->uuid
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bantuan $bantuan)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bantuan $bantuan)
    {
        abort(404);
    }
}
