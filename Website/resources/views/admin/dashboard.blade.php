@extends('layouts.main') {{-- Menggunakan layout admin utama yang baru --}}

@section('title', 'Dashboard Admin')

{{-- Mengisi @yield('header_title') di layouts.main.blade.php (Top Bar) --}}
@section('header_title', 'Dashboard Utama') 

@section('content')
    {{-- Konten spesifik untuk halaman dashboard --}}
    {{-- Tidak ada lagi kode untuk sidebar atau struktur flex di sini --}}

    <div class="mb-6">
        {{-- Judul halaman bisa dihilangkan jika @yield('header_title') sudah cukup jelas di Top Bar --}}
        {{-- <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1> --}}
        <div class="text-sm text-gray-500">
            Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}!
        </div>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $cards = [
                ['title' => 'Total Gejala', 'value' => $gejalaCount ?? 0, 'icon' => 'fas fa-notes-medical', 'color' => 'bg-blue-500'],
                ['title' => 'Jenis Depresi', 'value' => $depresiCount ?? 0, 'icon' => 'fas fa-brain', 'color' => 'bg-green-500'],
                ['title' => 'Total Admin', 'value' => $adminCount ?? 0, 'icon' => 'fas fa-users-cog', 'color' => 'bg-yellow-500']
            ];
        @endphp
        @foreach ($cards as $card)
        <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4">
            <div class="p-3 rounded-full {{ $card['color'] }} text-white">
                <i class="{{ $card['icon'] }} fa-2x"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">{{ $card['title'] }}</p>
                <p class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
@endsection

{{-- Tidak perlu @push('scripts') untuk sidebar toggle di sini, karena sudah ada di layouts.main --}}