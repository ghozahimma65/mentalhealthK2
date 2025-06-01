<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password; // Fasade PasswordBroker
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset; // Event setelah password direset
use Illuminate\Support\Str;
use App\Models\User; // Pastikan ini model User Anda

class ResetPasswordController extends Controller
{
    /**
     * Mereset password pengguna berdasarkan token yang diberikan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|email|exists:users,email', // Pastikan email ini ada di database
            'password' => 'required|string|min:6|confirmed', // 'confirmed' akan mencari field 'password_confirmation'
        ],[
            'token.required' => 'Token reset password wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.exists' => 'Alamat email ini tidak cocok dengan permintaan reset password yang ada.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus :min karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422); // Status 422 Unprocessable Entity
        }

        // Menggunakan PasswordBroker untuk mencoba mereset password.
        // Credentials harus berisi 'email', 'password', 'password_confirmation', dan 'token'.
        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) { // Pastikan type hint User sesuai dengan model Anda
                // Fungsi callback ini akan dijalankan jika token dan email valid.
                // Di sini kita mengisi password baru dan remember token.
                $user->forceFill([ // Menggunakan forceFill untuk mengisi password
                    'password' => Hash::make($password) // Selalu hash password baru
                ])->setRememberToken(Str::random(60)); // Set remember token baru (opsional untuk API)

                $user->save(); // Simpan perubahan pada user

                event(new PasswordReset($user)); // Memicu event PasswordReset bawaan Laravel
            }
        );

        // Periksa hasil dari proses reset
        if ($response == Password::PASSWORD_RESET) {
            // Password berhasil direset
            return response()->json([
                'success' => true,
                'message' => 'Password Anda telah berhasil direset. Silakan login dengan password baru Anda.'
            ], 200);
        }

        // Jika gagal (misalnya token tidak valid, email tidak cocok dengan token, atau token kedaluwarsa)
        // Variabel $response akan berisi konstanta error dari PasswordBroker,
        // seperti Password::INVALID_TOKEN, Password::INVALID_USER, dll.
        \Log::warning("ResetPasswordController: Failed to reset password. PasswordBroker response: " . $response);
        return response()->json([
            'success' => false,
            'message' => 'Gagal mereset password. Token mungkin tidak valid, sudah kedaluwarsa, atau email tidak cocok.',
            // 'error_code' => $response // Anda bisa mengirim kode error spesifik jika diperlukan
        ], 400); // Status 400 Bad Request
    }
}