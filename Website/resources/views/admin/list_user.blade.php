@extends('layouts.main') {{-- Menggunakan layout admin utama --}}

@section('title', 'Tambah Admin Baru')

{{-- Mengisi @yield('header_title') di layouts.main.blade.php (Top Bar) --}}
@section('header_title', 'Tambah Admin')

@section('content')
    {{-- Konten spesifik untuk halaman Tambah Admin --}}
    {{-- Struktur <header> dan <nav class="hidden md:flex ..."> (sidebar) sudah dihapus --}}
    {{-- karena sudah disediakan oleh layouts.main.blade.php --}}

    {{-- Breadcrumb --}}
<div class="flex items-center mb-6 space-x-1 text-sm">
    <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Admin</a>
    <span class="text-gray-500">/</span>
    <span class="font-semibold text-gray-700">Daftar Admin</span>
</div>

<div class="p-6 bg-white rounded-lg shadow md:p-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800 md:text-2xl">Daftar Admin</h2>
        <a href="{{ route('admin.tambah') }}" class="px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-green-500 rounded-md hover:bg-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Admin
        </a>
    </div>

    @if (session('success'))
        <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Email
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($admins as $admin)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{ $admin->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $admin->email }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a href="{{ route('admin.edit', $admin->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.hapus', $admin->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap" colspan="3">
                            Tidak ada data admin.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $admins->links() }}
</div>
@endsection