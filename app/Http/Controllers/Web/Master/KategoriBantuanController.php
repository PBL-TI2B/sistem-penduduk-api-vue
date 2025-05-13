<?php

namespace App\Http\Controllers\Web\Master;
use App\Http\Controllers\Controller;
use App\Models\KategoriBantuan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KategoriBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Master/KategoriBantuan/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
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
    public function show(KategoriBantuan $kategoriBantuan)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriBantuan $kategoriBantuan)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriBantuan $kategoriBantuan)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriBantuan $kategoriBantuan)
    {
        abort(404);
    }
}
