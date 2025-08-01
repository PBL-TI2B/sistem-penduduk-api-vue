<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Rw;
use App\Http\Resources\RwResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RwController extends Controller
{
    public function index(Request $request)
    {
        $rw = Rw::with(['dusun'])->withCount('rt');

        // Filter by nomor_rw (exact)
        if ($request->has('nomor_rw')) {
            $rw->where('nomor_rw', $request->nomor_rw);
        }

        // Filter by search (partial)
        if ($request->filled('search')) {
            $search = $request->search;
            $rw->where('nomor_rw', 'like', "%{$search}%");
        }

        // Pagination
        $rw = $rw->paginate(10);

        // Wrap with resource
        $collection = RwResource::collection($rw->getCollection());
        $rw->setCollection(collect($collection));

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data RW',
            'data' => $rw,
        ]);
    }

    public function store(Request $request)
    {
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

        $rw->load('dusun');

        return response()->json([
            'success' => true,
            'message' => 'RW Created',
            'data' => new RwResource($rw),
        ]);
    }

    public function show(Rw $rw)
    {
        $rw->load('dusun');
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ambil data RW',
            'data' => new RwResource($rw),
        ]);
    }

    public function update(Request $request, Rw $rw)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rw' => 'required|string|max:255',
            'dusun_id' => 'required|exists:dusun,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rw->update([
            'nomor_rw' => $request->nomor_rw,
            'dusun_id' => $request->dusun_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'RW Updated',
            'data' => new RwResource($rw),
        ]);
    }

    public function destroy(Rw $rw)
    {
        $rw->delete();
        return response()->json([
            'success' => true,
            'message' => 'RW Deleted',
            'data' => null,
        ]);
    }
}
