<?php

namespace App\Http\Controllers\Web\Master;

use Inertia\Inertia;
use App\Models\KurangMampu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KurangMampuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/KurangMampu/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // abort(404);
        return Inertia::render('Master/KurangMampu/Create');
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
    public function show(KurangMampu $kurangMampu)
    {
        abort(404);
        // return Inertia::render('Master/KurangMampu/Show', [
        //     'uuid' => $kurangMampu->uuid
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KurangMampu $kurangMampu)
    {
        abort(404);
        // return Inertia::render('Master/KurangMampu/Edit', [
        //     'uuid' => $kurangMampu->uuid
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KurangMampu $kurangMampu)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KurangMampu $kurangMampu)
    {
        abort(404);
    }
}
