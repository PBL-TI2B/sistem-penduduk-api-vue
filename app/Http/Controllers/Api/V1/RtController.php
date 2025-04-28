<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Rt;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RtController extends Controller
{
    public function index()
    {
        // Fetch all RT
        $rt = Rt::with(['rw'])->paginate(10);
        return new ApiResource(true, 'Daftar RT', $rt);
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

        return new ApiResource(true, 'RT Created', $rt);
    }
    
    public function show(Rt $rt)
    {
        // Fetch a specific RT by UUID
        $rt->load(['rw']);
        return new ApiResource(true, 'Detail RT', $rt);
    }
}