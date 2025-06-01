<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password; // Fasade PasswordBroker
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Untuk logging

class ForgotPasswordController extends Controller
{
    /**
     * Mengirim email link reset password.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // Pastikan email ada di tabel users
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.exists' => 'Alamat email tidak terdaftar di sistem kami.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422); // Status 422 untuk error validasi
        }

        // Mengirim link reset menggunakan PasswordBroker bawaan Laravel
        $response = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Link reset password telah dikirim ke alamat email Anda.'
            ], 200);
        }

        // Jika gagal mengirim link, catat respons dari PasswordBroker dan kembalikan error 400
        Log::error("ForgotPasswordController: Failed to send reset link. Response from PasswordBroker: " . $response);
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim link reset password. Silakan coba lagi atau hubungi dukungan jika masalah berlanjut.',
            // Anda bisa memilih untuk tidak mengirim 'error_code' ke klien secara langsung
            // 'error_code_debug' => $response // Mungkin untuk debugging internal saja
        ], 400); // Status 400 Bad Request untuk kegagalan proses ini
    }
}