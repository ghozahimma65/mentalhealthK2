<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User diimport
use Illuminate\Support\Facades\Hash; // Untuk hashing password (jika tambah user baru)
use Illuminate\Validation\ValidationException; // Untuk validasi
use Illuminate\Support\Facades\Log; // Untuk logging

class AdminTambahController extends Controller
{
    /**
     * Menampilkan form untuk menambah admin atau user baru, atau mengubah role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil daftar user yang ada untuk dipilih (jika ingin mengubah role)
        // Asumsi _id adalah primary key dan string
        $users = User::orderBy('name')->get(['_id', 'name', 'email', 'role']); 

        return view('admin.tambah', compact('users'));
    }

    /**
     * Memproses permintaan untuk menambah user baru atau mengubah role user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'action_type' => ['required', 'string', 'in:create_new,assign_role'],
            'user_id' => ['required_if:action_type,assign_role', 'string', 'nullable'],
            'name' => ['required_if:action_type,create_new', 'string', 'max:255', 'nullable'],
            'email' => ['required_if:action_type,create_new', 'string', 'email', 'max:255', 'nullable'],
            'password' => ['required_if:action_type,create_new', 'string', 'min:8', 'nullable'],
            'role' => ['required', 'string', 'in:user,admin'], // Role bisa 'user' atau 'admin'
        ]);

        try {
            if ($request->action_type === 'create_new') {
                // Buat user baru dengan role yang dipilih
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]);
                $message = "Pengguna baru '{$user->name}' dengan role '{$user->role}' berhasil ditambahkan!";
            } elseif ($request->action_type === 'assign_role') {
                // Ubah role user yang sudah ada
                $user = User::find($request->user_id);
                if (!$user) {
                    return redirect()->back()->with('error', 'Pengguna tidak ditemukan.')->withInput();
                }
                if ($user->role === $request->role) {
                     return redirect()->back()->with('warning', 'Role pengguna sudah sama dengan yang dipilih.')->withInput();
                }

                $user->role = $request->role;
                $user->save();
                $message = "Role pengguna '{$user->name}' berhasil diubah menjadi '{$user->role}'.";
            }
        } catch (ValidationException $e) {
            Log::error("Validation error in AdminTambahController: " . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error("Error in AdminTambahController: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.tambah')->with('success', $message);
    }
}