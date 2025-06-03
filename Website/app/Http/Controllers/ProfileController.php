<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect; // Pastikan ini diimport
use Illuminate\Validation\Rules; // Pastikan ini diimport untuk Rules\Password

class ProfileController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), // Mengirim objek user yang sedang login ke view
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi data input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Validasi email untuk unique, kecuali email user yang sedang login sendiri
            // Untuk MongoDB, '_id' biasanya string, jadi gunakan itu di unique rule
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        // Isi properti user dengan data baru
        $user->fill($request->validated());

        // Jika email berubah, set email_verified_at menjadi null (memerlukan verifikasi ulang)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save(); // Simpan perubahan ke database

        // Redirect kembali ke halaman edit profil dengan pesan sukses
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'], // Meminta password user saat ini
        ]);

        $user = $request->user();

        Auth::logout(); // Logout user dari sesi web

        $user->delete(); // Hapus user dari database

        // Invalidate sesi dan regenerate token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return Redirect::to('/');
    }
}