<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_staff' => 'required|digits:5',
            'password' => 'required'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan, periksa kembali!',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('no_staff', $request->no_staff)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'No Staff atau password tidak sesuai.',
            ], 401);
        }

        if ($user->role !== 'teknisi') {
            return response()->json([
                'status' => false,
                'message' => 'Anda bukan teknisi!',
            ], 403);
        }

        if (!$user->status) {
            return response()->json([
                'status' => false,
                'message' => 'Akun anda tidak aktif! Hubungi manager marketing untuk informasi lebih lanjut.',
            ], 403);
        }

        // Coba melakukan otentikasi dengan password yang diberikan
        if (Auth::attempt(['no_staff' => $request->no_staff, 'password' => $request->password])) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login',
                'token' => $user->createToken('mobile-api')->plainTextToken,
                'user' => Auth::user(),
                'request' => $request->all(),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Terjadi Kesalahan, periksa kembali.',
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil logout',
        ], 200);
    }
}
