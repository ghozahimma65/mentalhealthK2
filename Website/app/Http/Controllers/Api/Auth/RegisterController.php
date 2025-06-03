<?php

namespace App\Http\Controllers\Api\Auth; 

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException; 

class RegisterController extends Controller
{
    /**
     * Handle an incoming API registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'string', Rules\Password::defaults()], // 'confirmed' tidak diperlukan untuk API
            ]);
        } catch (ValidationException $e) {
            // Mengembalikan error validasi dalam format JSON
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422); // Status code 422 untuk Unprocessable Entity (error validasi)
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', 
        ]);

        // Memicu event Registered (jika ada listener seperti email verification)
        event(new Registered($user));

        // Generate token API menggunakan Laravel Sanctum
        // Pastikan model User Anda menggunakan trait HasApiTokens
        $token = $user->createToken('auth_token')->plainTextToken; // 'auth_token' bisa diganti nama token Anda

        // Mengembalikan respons JSON dengan token dan informasi user
        return response()->json([
            'message' => 'Registration successful!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
            'token_type' => 'Bearer', // Tipe token untuk header Authorization
        ], 201); // Status code 201 untuk Created
    }
}