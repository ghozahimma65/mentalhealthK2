<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User Anda sudah benar
use Illuminate\Support\Facades\Auth; // Kita akan gunakan Auth::id() jika perlu
// use Illuminate\Validation\Rules\Password; // Tidak kita gunakan karena validasi password sederhana

class AuthController extends Controller
{
    /**
     * Method untuk login pengguna (non-admin) via API mobile.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401); // Unauthorized
        }

        // PENTING: Cek peran pengguna setelah kredensial valid
        if ($user->role === 'admin') { // Asumsi field peran di model User Anda adalah 'role'
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak diizinkan login melalui aplikasi mobile.'
            ], 403); // 403 Forbidden - Akses ditolak
        }

        // Jika bukan admin dan kredensial benar, buat token
        $tokenName = 'auth_token_user_' . $user->id;
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }

    /**
     * Method untuk registrasi pengguna baru via API mobile.
     * Pengguna yang diregistrasi akan otomatis mendapatkan peran 'user'.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Periksa kembali data input Anda.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Gunakan Hash::make() jika tidak pakai $casts 'hashed' di model
                // 'password' => $request->password, // Jika sudah pakai $casts 'hashed' di model User
                'role' => 'user', // <-- OTOMATIS SET PERAN SEBAGAI 'USER'
            ]);

            // Opsional: Jika Anda ingin pengguna langsung login setelah registrasi
            // $token = $user->createToken('register_token_user_' . $user->id)->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.',
                'data' => $user,
                // Jika auto-login, tambahkan token:
                // 'access_token' => $token,
                // 'token_type' => 'Bearer',
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Kesalahan saat registrasi: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal karena terjadi kesalahan pada server.',
            ], 500);
        }
    }
}