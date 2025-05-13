<?php

namespace App\Http\Controllers\Web\Master;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DesaController extends Controller
{
    public function index()
    {
        return Inertia::render('Master/Desa/Index');
    }

    public function create()
    {
        return Inertia::render('Master/Desa/Create');
    }
  
    public function store(Request $request)
    {
        abort(404);
    }

    public function show(Desa $desa)
    {
        return Inertia::render('Master/Desa/Show', [
            'uuid' => $desa->uuid
        ]);
    }

    public function edit(Desa $desa)
    {
        return Inertia::render('Master/Desa/Edit', [
            'uuid' => $desa->uuid
        ]);
    }

    public function update(Request $request, Desa $desa)
    {
        abort(404);
    }

    public function destroy(Desa $desa)
    {
        abort(404);
    }
