{{-- Menggunakan master layout resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Mengatur judul halaman yang akan muncul di tab browser --}}
@section('title', ($kode ?? 'Kode') . ' | ' . ($nama_gangguan ?? 'Nama Gangguan') . ' - Informasi Gangguan')

{{-- Konten utama halaman akan ditempatkan di sini --}}
@section('content')

    {{-- Bagian Header Informasi Gangguan (Kode, Nama, Kesimpulan) --}}
    {{-- Ini akan tampil di atas kartu konten utama, dengan latar belakangnya sendiri --}}
    <div class="bg-gray-100 p-4 md:p-6 rounded-lg shadow-md mb-6">
        <h1 class="text-xl md:text-2xl font-semibold text-[#023047]">
            {{ $kode ?? 'PXXX' }} | {{ $nama_gangguan ?? 'Nama Gangguan Tidak Tersedia' }}
        </h1>
        @if(isset($kesimpulan) && !empty($kesimpulan))
        <p class="mt-2 text-sm md:text-base text-gray-700 italic">
            {{ $kesimpulan }}
        </p>
        @endif
    </div>

    {{-- Kartu Konten Utama (Gambar dan Deskripsi Detail) --}}
    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <div class="text-gray-700">
            <h2 class="text-xl md:text-2xl font-semibold text-[#023047] mb-4 text-center">
                {{ $nama_gangguan ?? 'Detail Gangguan' }}
            </h2>

            {{-- Gambar Ilustrasi --}}
            @if(isset($path_gambar) && file_exists(public_path($path_gambar)))
                <img src="{{ asset($path_gambar) }}" alt="Ilustrasi {{ $nama_gangguan ?? 'Gangguan' }}" class="w-full max-w-md mx-auto h-auto rounded-lg shadow mb-6 border border-gray-200">
            @else
                <div class="text-center text-red-500 my-4 p-3 bg-red-100 rounded-md">
                    <i class="fas fa-image mr-2"></i>Gambar ilustrasi tidak ditemukan.
                </div>
            @endif

            {{-- Deskripsi Gangguan --}}
            <div class="prose max-w-none"> {{-- Kelas 'prose' dari Tailwind Typography bisa membantu styling teks --}}
                @if(isset($deskripsi_gangguan) && !empty($deskripsi_gangguan))
                <p class="mb-4 text-base leading-relaxed">
                    {{ $deskripsi_gangguan }}
                </p>
                @endif

                @if(!empty($poin_deskripsi))
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach($poin_deskripsi as $poin)
                            <li class="text-base leading-relaxed">
                                @if(is_string($poin) && str_contains($poin, ':'))
                                    <strong>{{ Illuminate\Support\Str::before($poin, ':') }}:</strong> {{ Illuminate\Support\Str::after($poin, ':') }}
                                @else
                                    {{ $poin }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    {{-- Jika Anda ingin menggunakan sidebar di halaman ini, Anda bisa membuat section sidebar --}}
    {{-- @section('sidebar')
        <aside class="w-64 bg-white p-4 shadow">
            <h3 class="font-semibold mb-2">Informasi Tambahan</h3>
            <p>Ini adalah sidebar untuk halaman gangguan.</p>
        </aside>
    @endsection --}}
@endsection
