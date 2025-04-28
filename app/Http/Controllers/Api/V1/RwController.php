<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Rw;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RwController extends Controller
{
    public function index()
    {
        // Fetch all RW
        $rw = Rw::with(['dusun'])->paginate(10);
        return new ApiResource(true, 'Daftar RW', $rw);
    }

    public function store(Request $request)
    {
        // Validate and create a new RW
        $validator = Validator::make($request->all(), [
            'nomor_rw' => 'required|string|max:255',
            'dusun_id' => 'required|exists:dusun,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rw = Rw::create([
            'nomor_rw' => $request->nomor_rw,
            'dusun_id' => $request->dusun_id,
        ]);

        return new ApiResource(true, 'RW Created', $rw);
    }

    public function show(Rw $rw)
    {
        $rw->load(['dusun']);
        return new ApiResource(true, 'Detail RW', $rw);
    }
}