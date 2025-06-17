<?php

namespace App\Http\Controllers\Web\Public;

use App\Models\Berita;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BeritaController extends Controller
{
    public function index()
    {
        return Inertia::render('Berita');
    }

    public function show(Berita $berita)
    {
        return Inertia::render('DetailBerita',
        [
            'slug' => $berita->slug,
        ]);
    }
}
