@extends('admin.dashboard') {{-- Asumsi Anda menggunakan layout 'layouts.admin' --}}

@section('title', 'Ubah Role Pengguna') {{-- Judul halaman diubah --}}

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Ubah Role Pengguna</h1>
        <p class="mb-8 text-gray-600">Pilih pengguna dan ubah role-nya menjadi 'user' atau 'admin'.</p>

        {{-- Pesan Sukses/Error (Diambil dari Controller) --}}
        @if (session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if (session('warning'))
            <div class="relative px-4 py-3 mb-4 text-yellow-700 bg-yellow-100 border border-yellow-400 rounded" role="alert">
                <strong class="font-bold">Peringatan!</strong>
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        @endif

        {{-- Pesan Error Validasi (dari Laravel) --}}
        @if ($errors->any())
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong class="font-bold">Validasi Gagal!</strong>
                <span class="block sm:inline">Mohon perbaiki kesalahan berikut:</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 md:grid-cols-1"> {{-- Grid diubah menjadi 1 kolom --}}
            {{-- Form Tambah Pengguna Baru (DIHILANGKAN DARI SINI) --}}
            {{--
            <div class="p-8 bg-white shadow-lg rounded-xl">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">1. Tambah Pengguna Baru</h2>
                <p class="mb-6 text-gray-600">Buat akun pengguna atau admin baru.</p>
                <form action="{{ route('admin.tambah.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action_type" value="create_new">
                    <div class="mb-4">
                        <label for="new_name" class="block mb-2 text-sm font-bold text-gray-700">Nama</label>
                        <input type="text" id="new_name" name="name" class="form-input" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_email" class="block mb-2 text-sm font-bold text-gray-700">Email</label>
                        <input type="email" id="new_email" name="email" class="form-input" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="block mb-2 text-sm font-bold text-gray-700">Password</label>
                        <input type="password" id="new_password" name="password" class="form-input" required>
                    </div>
                    <div class="mb-6">
                        <label for="new_role" class="block mb-2 text-sm font-bold text-gray-700">Role</label>
                        <select id="new_role" name="role" class="form-select" required>
                            <option value="user">Pengguna Biasa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                        Tambah Pengguna
                    </button>
                </form>
            </div>
            --}}

            {{-- Form Ubah Role Pengguna yang Ada (Ini yang dipertahankan) --}}
            <div class="p-8 bg-white shadow-lg rounded-xl">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">Ubah Role Pengguna</h2> {{-- Judul diubah --}}
                <p class="mb-6 text-gray-600">Pilih pengguna dan ubah role-nya menjadi 'user' atau 'admin'.</p>
                <form action="{{ route('admin.tambah.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action_type" value="assign_role">

                    <div class="mb-4">
                        <label for="user_id" class="block mb-2 text-sm font-bold text-gray-700">Pilih Pengguna</label>
                        <select id="user_id" name="user_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Pengguna</option>
                            @foreach ($users as $userItem)
                                <option value="{{ $userItem->_id }}" {{ old('user_id') == $userItem->_id ? 'selected' : '' }}>
                                    {{ $userItem->name }} ({{ $userItem->email }}) - Role: {{ $userItem->role }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-6">
                        <label for="assign_role" class="block mb-2 text-sm font-bold text-gray-700">Tetapkan Role</label>
                        <select id="assign_role" name="role" class="form-select" required>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna Biasa</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                        Ubah Role
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection