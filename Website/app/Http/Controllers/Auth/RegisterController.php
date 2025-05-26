<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan Anda memiliki view ini
    }

    /**
     * Proses registrasi user baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class), // Pastikan email unik di koleksi User
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' akan mencari 'password_confirmation'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buat user baru dengan role 'user'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set role default 'user'
        ]);

        // Opsional: Langsung login user setelah registrasi
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}