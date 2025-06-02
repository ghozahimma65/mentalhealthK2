@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Pilih Tipe Riwayat') {{-- Judul halaman --}}

@section('content')
    <div class="container p-6 mx-auto text-center lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Pilih Tipe Riwayat</h1>
        <p class="mb-8 text-gray-600">Silakan pilih jenis riwayat yang ingin Anda lihat:</p>

        <div class="flex flex-col justify-center gap-6 md:flex-row">
            {{-- Tombol untuk Riwayat Diagnosis Awal --}}
            <a href="{{ route('predictions.history') }}" 
               class="flex flex-col items-center justify-center flex-1 max-w-sm p-8 transition duration-200 ease-in-out transform rounded-lg shadow-md bg-blue-50 hover:bg-blue-100 hover:scale-105">
                <i class="mb-4 text-5xl text-blue-600 fas fa-robot"></i>
                <h2 class="mb-2 text-xl font-bold text-gray-800">Riwayat Diagnosis Awal</h2>
                <p class="text-sm text-gray-600">Lihat semua diagnosis awal yang pernah Anda lakukan.</p>
            </a>

            {{-- Tombol untuk Riwayat Perkembangan (Outcome) --}}
            <a href="{{ route('outcome.comprehensive_history') }}" {{-- Menuju halaman riwayat outcome saja --}}
               class="flex flex-col items-center justify-center flex-1 max-w-sm p-8 transition duration-200 ease-in-out transform rounded-lg shadow-md bg-purple-50 hover:bg-purple-100 hover:scale-105">
                <i class="mb-4 text-5xl text-purple-600 fas fa-chart-line"></i>
                <h2 class="mb-2 text-xl font-bold text-gray-800">Riwayat Perkembangan Pengobatan</h2>
                <p class="text-sm text-gray-600">Telusuri semua catatan progres dan hasil klasifikasi perkembangan Anda.</p>
            </a>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-800">
                <i class="mr-1 fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection