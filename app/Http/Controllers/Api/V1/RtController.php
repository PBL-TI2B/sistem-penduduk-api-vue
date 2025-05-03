<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Rt;
use App\Http\Resources\ApiResource;
use App\Http\Resources\RtResource;
use App\Http\Resources\PaginatedResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RtController extends Controller
{
    public function index()
    {
        // Fetch all RT
        $rt = Rt::with(['rw'])->paginate(10);
        $collection = RtResource::collection($rt->getCollection());
        $rt->setCollection(collect($collection));
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data RT',
            'data' => $rt,
        ]);
    }

    public function store(Request $request)
    {
        // Validate and create a new RT
        $validator = Validator::make($request->all(), [
            'nomor_rt' => 'required|string|max:255',
            'rw_id' => 'required|exists:rw,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rt = Rt::create([
            'nomor_rt' => $request->nomor_rt,
            'rw_id' => $request->rw_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'RT Created',
            'data' => new RtResource($rt),
        ]);
    }
    
    public function show(Rt $rt)
    {
        // Fetch a specific RT by UUID
        $rt->load(['rw']);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data RT',
            'data' => new RtResource($rt),
        ]);
    }

    public function update(Request $request, Rt $rt)
    {
        // Validate and update the RT
        $validator = Validator::make($request->all(), [
            'nomor_rt' => 'required|string|max:255',
            'rw_id' => 'required|exists:rw,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rt->update([
            'nomor_rt' => $request->nomor_rt,
            'rw_id' => $request->rw_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'RT Updated',
            'data' => new RtResource($rt),
        ]);
    }

    public function destroy(Rt $rt)
    {
        // Delete the RT
        $rt->delete();
        return response()->json([
            'success' => true,
            'message' => 'RT Deleted',
            'data' => null,
        ]);
    }
}