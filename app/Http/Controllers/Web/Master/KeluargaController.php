<?php

namespace App\Http\Controllers\Web\Master;

use App\Models\KartuKeluarga;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index()
    {
        return inertia('Master/Keluarga/Index');
    }

    public function show(KartuKeluarga $keluarga) 
    {
        
        return inertia('Master/Keluarga/Show', [
            'uuid' => $keluarga->uuid,
        ]);
    }

    public function create()
    {
        return inertia('Master/Keluarga/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_kk' => 'required|string|max:16',
            'kepala_keluarga' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'dusun_id' => 'required|exists:dusun,id',
        ]);

        KartuKeluarga::create($data);

        return redirect()->route('keluarga.index')->with('success', 'Kartu Keluarga berhasil dibuat.');
    }

    public function edit(KartuKeluarga $keluarga)
    {
        return inertia('Master/Keluarga/Edit', [
                'uuid' => $keluarga->uuid,
            ]
        );
    }

    public function update(Request $request, KartuKeluarga $keluarga)
    {
        $data = $request->validate([
            'nomor_kk' => 'required|string|max:16',
            'kepala_keluarga' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'dusun_id' => 'required|exists:dusun,id',
        ]);

        $keluarga->update($data);

        return redirect()->route('keluarga.index')->with('success', 'Kartu Keluarga berhasil diperbarui.');
    }

    public function destroy(KartuKeluarga $keluarga)
    {
        $keluarga->delete();

        return redirect()->route('keluarga.index')->with('success', 'Kartu Keluarga berhasil dihapus.');
    }
}
