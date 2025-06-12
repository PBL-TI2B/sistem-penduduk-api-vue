<?php

namespace App\Http\Controllers\Web\Master;

use App\Models\Kelahiran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelahiranController extends Controller
{
    public function index()
    {
        return inertia('Master/Kelahiran/Index');
    }

    public function create()
    {
        return inertia('Master/Kelahiran/Create');
    }

    public function edit(Kelahiran $kelahiran)
    {
        return inertia('Master/Kelahiran/Edit', [
            'uuid' => $kelahiran->uuid,
        ]);
    }
}
