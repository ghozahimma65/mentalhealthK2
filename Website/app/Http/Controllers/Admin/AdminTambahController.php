<?php
// app/Http/Controllers/Admin/AdminTambahController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Sesuaikan jika model User Anda berbeda
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminTambahController extends Controller
{
    // Method untuk menampilkan form tambah admin
    public function create()
    {
        return view('admin.tambah_admin'); // Pastikan path view ini benar
    }

    // Method untuk menyimpan data admin baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => 'admin', // Tambahkan jika Anda menggunakan kolom role
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin baru berhasil ditambahkan!');
    }
}