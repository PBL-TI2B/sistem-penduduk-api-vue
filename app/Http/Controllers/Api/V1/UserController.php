<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Resources\ApiResource;
// use App\Http\Resources\RtResource;
use App\Http\Resources\PaginatedResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Fetch all RT
        $user = User::paginate(10);
        return new ApiResource(true, 'Daftar Data User', $user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:aktif,nonaktif',
            'perangkat_id' => 'nullable|exists:perangkat_desa,id',
            'role' => 'required|in:superadmin,admin,rt,rw'  
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

        $user->assignRole($request->role); 

        return new ApiResource(true, 'User Berhasil Ditambahkan', $user);
    }

    
    public function show(User $user)
    {
        return new ApiResource(true, 'Detail Data User', $user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username,' . $user->id . '|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:aktif,nonaktif',
            'perangkat_id' => 'nullable|exists:perangkat_desa,id',
            'role' => 'required|in:superadmin,admin,rt,rw'  
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

        $user->syncRoles([$request->role]); 

        return new ApiResource(true, 'User Berhasil Diperbarui', $user);
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