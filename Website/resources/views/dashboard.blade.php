{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.main') {{-- Menggunakan layout umum aplikasi Anda --}}

@section('title', 'Dashboard Pengguna') {{-- Mengatur judul halaman --}}

@section('header_title') {{-- Mengisi slot header_title di layouts.main --}}
    Dashboard Pengguna
@endsection

@section('content') {{-- Mengisi slot content di layouts.main --}}
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Anda berhasil login sebagai Pengguna Biasa!") }}
                </div>
            </div>
        </div>
    </div>
@endsection