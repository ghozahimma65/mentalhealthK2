@extends('layouts.main') {{-- Menggunakan layout admin utama --}}

@section('title', 'Tambah Admin Baru')

{{-- Mengisi @yield('header_title') di layouts.main.blade.php (Top Bar) --}}
@section('header_title', 'Tambah Admin')

@section('content')
    {{-- Konten spesifik untuk halaman Tambah Admin --}}
    {{-- Struktur <header> dan <nav class="hidden md:flex ..."> (sidebar) sudah dihapus --}}
    {{-- karena sudah disediakan oleh layouts.main.blade.php --}}

    {{-- Breadcrumb --}}
    <div class="flex items-center space-x-1 mb-6 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Admin</a>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 font-semibold">Tambah Admin Baru</span>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-lg shadow">
        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6">Tambah Admin</h2>

        {{-- Jika ada error validasi, bisa ditampilkan di sini --}}
        {{-- @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md text-xs">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        {{-- Pastikan action form mengarah ke rute yang benar untuk menyimpan admin baru --}}
        <form method="POST" action="{{ route('admin.tambah.store') }}" autocomplete="off" class="max-w-3xl space-y-6">
          @csrf {{-- Jangan lupa CSRF token --}}
          {{-- ... sisa field form Anda ... --}}
      </form>
            @csrf
            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-4">
                <label class="w-full md:w-48 font-semibold text-[#2C3E70] text-sm select-none flex-shrink-0" for="name">
                    Nama Lengkap :
                </label>
                <input class="flex-grow bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 text-[#2C3E70] text-base" 
                       id="name" 
                       name="name" {{-- Tambahkan atribut name --}}
                       type="text"
                       value="{{ old('name') }}" {{-- Untuk mempertahankan input jika ada error --}}
                       required />
            </div>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-4">
                <label class="w-full md:w-48 font-semibold text-[#2C3E70] text-sm select-none flex-shrink-0" for="email">
                    Alamat Email :
                </label>
                <input class="flex-grow bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 text-[#2C3E70] text-base" 
                       id="email" 
                       name="email" {{-- Tambahkan atribut name --}}
                       type="email"
                       value="{{ old('email') }}"
                       required />
            </div>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-4">
                <label class="w-full md:w-48 font-semibold text-[#2C3E70] text-sm select-none flex-shrink-0" for="password">
                    Password :
                </label>
                <input class="flex-grow bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 text-[#2C3E70] text-base" 
                       id="password" 
                       name="password" {{-- Tambahkan atribut name --}}
                       type="password"
                       required />
            </div>

            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-4">
                <label class="w-full md:w-48 font-semibold text-[#2C3E70] text-sm select-none flex-shrink-0" for="password_confirmation">
                    Konfirmasi Password :
                </label>
                <input class="flex-grow bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md px-4 py-2 text-[#2C3E70] text-base" 
                       id="password_confirmation" 
                       name="password_confirmation" {{-- Tambahkan atribut name --}}
                       type="password"
                       required />
            </div>

            <div class="flex md:items-center md:space-x-4 pt-4 md:pl-48">
                {{-- Label "Frame" dihilangkan karena sepertinya tidak relevan --}}
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-md px-6 py-2.5 transition duration-300" type="submit">
                    Simpan Admin Baru
                </button>
                <a href="{{ route('admin.dashboard') }}" {{-- Atau ke halaman daftar admin jika ada --}}
                   class="ml-4 text-gray-600 hover:text-gray-800 font-medium text-sm py-2.5">
                   Batal
                </a>
            </div>
        </form>
    </div>
@endsection