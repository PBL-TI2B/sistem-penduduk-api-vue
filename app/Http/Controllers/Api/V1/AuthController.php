<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => 'aktif',
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return new ApiResource(true, 'Berhasil mendaftar', [
            'user' => $user,
            'access_token' => $token,
            'token_type'=> 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('username', 'password');
        $user = User::where('username', $request->username)->first();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return new ApiResource(true, 'Berhasil login', [
            'user' => $user,
            'access_token' => $token,
            'token_type'=> 'Bearer',
        ]);
    }

    public function me()
    {
        $user = [
            'id' => Auth::user()->id,
            'username' => Auth::user()->username,
            'role' => Auth::user()->getRoleNames()->first(),
            'status' => Auth::user()->status,
            'perangkat_id' => Auth::user()->perangkat_id,
        ];
        return new ApiResource(true, 'Berhasil mendapatkan data user', $user);
    }

    public function logout() 
    {
        Auth::user()->tokens()->delete();
        return new ApiResource(true, 'Berhasil logout', null);
    }
}
