<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan Anda mengimpor model User
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Tambahkan ini untuk Rule::unique

class DetailPenggunaController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna terdaftar.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua user dari database, diurutkan berdasarkan nama
        $users = User::orderBy('name', 'asc')->get();

        return view('admin.detailpengguna', compact('users'));
    }

    /**
     * Menampilkan form untuk mengedit data pengguna.
     *
     * @param string $id ID dari user yang akan diedit
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            // PERBAIKAN: Mengarahkan ke rute 'admin.detailpengguna'
            return redirect()->route('admin.detailpengguna')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Menggunakan view 'admin.editpengguna' sesuai permintaan Anda
        return view('admin.editpengguna', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id ID dari user yang akan diperbarui
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            // PERBAIKAN: Mengarahkan ke rute 'admin.detailpengguna'
            return redirect()->route('admin.detailpengguna')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // PERBAIKAN: Menggabungkan Rule::unique dengan array validasi email
                Rule::unique('users')->ignore($user->id), // Memastikan email unik, kecuali untuk user ini sendiri
            ],
            // Tambahkan validasi untuk field lain seperti password jika ingin diubah melalui edit ini
            // 'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            // if (isset($validatedData['password'])) {
            //     $user->password = bcrypt($validatedData['password']);
            // }
            $user->save();

            // PERBAIKAN: Mengarahkan ke rute 'admin.detailpengguna'
            return redirect()->route('admin.detailpengguna')->with('success', 'Data pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            // Menambahkan penanganan error
            return redirect()->back()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus pengguna dari database.
     *
     * @param string $id ID dari user yang akan dihapus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            // PERBAIKAN: Mengarahkan ke rute 'admin.detailpengguna'
            return redirect()->route('admin.detailpengguna')->with('error', 'Pengguna tidak ditemukan.');
        }

        try {
            // Optional: Hapus juga data diagnosis yang terkait dengan user ini jika diperlukan
            // DiagnosisResult::where('user_id', $user->id)->delete();

            $user->delete();

            // PERBAIKAN: Mengarahkan ke rute 'admin.detailpengguna'
            return redirect()->route('admin.detailpengguna')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            // Menambahkan penanganan error
            return redirect()->back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}