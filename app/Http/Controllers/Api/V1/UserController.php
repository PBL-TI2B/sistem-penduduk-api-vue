<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'perangkatDesa.penduduk']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%$search%");
            });
        }

        $user = $query->paginate($request->get('per_page',10));
        return new ApiResource(true, 'Daftar Data User', $user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:aktif,nonaktif',
            'roles' => 'required|string|exists:roles,name',
            'perangkat_id' => 'nullable|exists:perangkat_desa,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'perangkat_id' => $request->perangkat_id,
        ]);

        $user->assignRole($request->roles); 

        return new ApiResource(true, 'User Berhasil Ditambahkan', $user->load(['roles', 'perangkatDesa.penduduk']));
    }

    public function show(User $user)
    {
        $user->load(['roles', 'perangkatDesa.penduduk']);
        return new ApiResource(true, 'Detail Data User', $user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'status' => 'required|in:aktif,nonaktif',
            'roles' => 'required|string|exists:roles,name',
            'perangkat_id' => 'nullable|exists:perangkat_desa,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'status' => $request->status,
            'perangkat_id' => $request->perangkat_id,
        ]);

        $user->syncRoles([$request->roles]); 

        return new ApiResource(true, 'User Berhasil Diperbarui', $user->load(['roles', 'perangkatDesa.penduduk']));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User Deleted',
            'data' => null,
        ]);
    }
}
