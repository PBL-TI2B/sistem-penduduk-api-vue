<?php

namespace App\Http\Controllers\Web\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelahiranController extends Controller
{
    public function index()
    {
        return inertia('Master/Kelahiran/Index');
    }
}
