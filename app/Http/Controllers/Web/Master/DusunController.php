<?php

namespace App\Http\Controllers\Web\Master;

use App\Http\Controllers\Controller;
use App\Models\Dusun;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DusunController extends Controller
{
    public function index()
    {
        return Inertia::render('Master/Dusun/Index');
    }

    public function create()
    {
        return Inertia::render('Master/Dusun/Create');
    }
  
    public function store(Request $request)
    {
        abort(404);
    }

    public function show(Dusun $Dusun)
    {
        return Inertia::render('Master/Dusun/Show', [
            'uuid' => $Dusun->uuid
        ]);
    }

    public function edit(Dusun $Dusun)
    {
        return Inertia::render('Master/Dusun/Edit', [
            'uuid' => $Dusun->uuid
        ]);
    }

    public function update(Request $request, Dusun $Dusun)
    {
        abort(404);
    }

    public function destroy(Dusun $Dusun)
    {
        abort(404);
    }
}