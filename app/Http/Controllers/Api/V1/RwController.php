<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Rw;
use App\Http\Resources\ApiResource;
use App\Http\Resources\RwResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RwController extends Controller
{
    public function index()
    {
        // Fetch all RW
        $rw = Rw::with(['dusun'])->paginate(10);
        $collection = RwResource::collection($rw->getCollection());
        $rw->setCollection(collect($collection));
        
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data RW',
            'data' => RwResource::collection($rw),
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'RW Created',
            'data' => new RwResource($rw),
        ]);
    }

    public function show(Rw $rw)
    {
        $rw->load(['dusun']);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data RW',
            'data' => new RwResource($rw),
        ]);
    }
}