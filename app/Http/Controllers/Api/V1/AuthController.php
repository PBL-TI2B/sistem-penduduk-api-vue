<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'perangkat_id' => 'nullable',
            'status'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => 'aktif',
        ]);

        $user->assignRole($request->role);

        $token = $user->createToken('auth_token')->plainTextToken;

        return new ApiResource(true, 'Berhasil menambah user', [
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

    public function me(User $user)
    {
        $user = User::with(['perangkatDesa.rt', 'perangkatDesa.rw'])->find(Auth::id());
        $user = $user->load('perangkatDesa');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data user',
            'data' => new AuthResource($user->load('perangkatDesa')),
        ]);
    }

    public function logout() 
    {
        Auth::user()->tokens()->delete();
        return new ApiResource(true, 'Berhasil logout', null);
    }

    /**
     * Request reset password (generate token untuk username)
     */
    public function requestPasswordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|exists:users,username',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return new ApiResource(false, 'Username tidak ditemukan', null);
        }

        // Generate reset token
        $token = Str::random(8); // Token 8 karakter untuk mudah diingat

        // Simpan token ke database (buat tabel password_reset_tokens)
        DB::table('password_reset_token')->updateOrInsert(
            ['username' => $request->username],
            [
                'username' => $request->username,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        return new ApiResource(true, 'Token reset password berhasil dibuat', [
            'reset_token' => $token,
            'username' => $request->username,
            'message' => 'Gunakan token ini untuk reset password dalam 24 jam',
            'expires_at' => Carbon::now()->addHours(24)->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Reset password ke default menggunakan token
     */
    public function resetPasswordDefault(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek token
        $passwordReset = DB::table('password_reset_tokens')
                          ->where('username', $request->username)
                          ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return new ApiResource(false, 'Token reset password tidak valid', null);
        }

        // Cek apakah token sudah expired (24 jam)
        if (Carbon::parse($passwordReset->created_at)->addHours(24)->isPast()) {
            return new ApiResource(false, 'Token reset password telah expired', null);
        }

        // Update password ke default
        $user = User::where('username', $request->username)->first();
        
        if (!$user) {
            return new ApiResource(false, 'User tidak ditemukan', null);
        }

        // Password default bisa disesuaikan sesuai kebutuhan
        $defaultPassword = 'password123'; // atau bisa 'username123', dll
        
        $user->update([
            'password' => Hash::make($defaultPassword)
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('username', $request->username)->delete();

        // Revoke semua token yang ada
        $user->tokens()->delete();

        return new ApiResource(true, 'Password berhasil direset ke default', [
            'username' => $request->username,
            'default_password' => $defaultPassword,
            'message' => 'Silahkan login dengan password default dan ubah password Anda'
        ]);
    }

    /**
     * Reset password langsung oleh admin (tanpa token)
     */
    public function adminResetToDefault(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|exists:users,username',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Pastikan hanya admin yang bisa akses
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::where('username', $request->username)->first();
        
        if (!$user) {
            return new ApiResource(false, 'User tidak ditemukan', null);
        }

        // Password default
        $defaultPassword = 'password123';
        
        $user->update([
            'password' => Hash::make($defaultPassword)
        ]);

        // Revoke semua token user yang direset
        $user->tokens()->delete();

        return new ApiResource(true, 'Password user berhasil direset ke default', [
            'username' => $request->username,
            'default_password' => $defaultPassword,
            'message' => 'User dapat login dengan password default'
        ]);
    }

    /**
     * Ganti password (user yang sudah login)
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return new ApiResource(false, 'Password lama tidak sesuai', null);
        }

        // Cek apakah password baru sama dengan password lama
        if (Hash::check($request->new_password, $user->password)) {
            return new ApiResource(false, 'Password baru tidak boleh sama dengan password lama', null);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Opsional: Revoke semua token kecuali yang sedang digunakan
        // $user->tokens()->where('id', '!=', $user->currentAccessToken()->id)->delete();

        return new ApiResource(true, 'Password berhasil diganti', null);
    }

    /**
     * Reset password oleh admin (dengan password custom)
     */
    public function adminResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|exists:users,username',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Pastikan hanya admin yang bisa akses (sesuaikan dengan sistem role Anda)
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::where('username', $request->username)->first();

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Revoke semua token user yang direset
        $user->tokens()->delete();

        return new ApiResource(true, 'Password user berhasil direset oleh admin', [
            'username' => $request->username,
            'message' => 'Password berhasil diubah'
        ]);
    }
}