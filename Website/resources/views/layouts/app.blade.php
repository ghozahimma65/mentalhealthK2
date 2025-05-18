
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Poppins", sans-serif; }
    </style>
</head>
<body class="bg-[#EDF6F9] text-[#2C3E70] min-h-screen">

    {{-- HEADER --}}
    @include('layouts.main')

    <main class="flex min-h-[calc(100vh-56px)]">
        
        {{-- SIDEBAR: Tampil jika @section('sidebar') tidak dihapus --}}
        @hasSection('sidebar')
            @yield('sidebar')
        @endif

        {{-- KONTEN --}}
        <section class="flex-grow p-8">
            @yield('content')
        </section>
    </main>

</body>
</html>
{{-- Menggunakan master layout resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Mengatur judul halaman yang akan muncul di tab browser --}}
@section('title', $kode . ' | ' . $nama_gangguan . ' - Informasi Gangguan')

{{-- Konten utama halaman akan ditempatkan di sini --}}
@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">

        {{-- Bagian Header Informasi Gangguan (Kode, Nama, Kesimpulan) --}}
        <div class="mb-6 pb-4 border-b border-gray-200">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#023047]">
                {{ $kode }} | {{ $nama_gangguan }}
            </h1>
            <p class="mt-2 text-sm md:text-base text-gray-600 italic">
                {{ $kesimpulan }}
            </p>
        </div>

        {{-- Konten Detail Gangguan --}}
        <div class="text-gray-700">
            <h2 class="text-xl md:text-2xl font-semibold text-[#023047] mb-4 text-center">
                {{ $nama_gangguan }}
            </h2>

            {{-- Gambar Ilustrasi --}}
            @if(isset($path_gambar) && file_exists(public_path($path_gambar)))
                <img src="{{ asset($path_gambar) }}" alt="Ilustrasi {{ $nama_gangguan }}" class="w-full max-w-md mx-auto h-auto rounded-lg shadow mb-6 border border-gray-200">
            @else
                <div class="text-center text-red-500 my-4">
                    <i class="fas fa-image mr-2"></i>Gambar ilustrasi tidak ditemukan.
                </div>
            @endif

            {{-- Deskripsi Gangguan --}}
            <div class="prose max-w-none"> {{-- Kelas 'prose' dari Tailwind Typography bisa membantu styling teks --}}
                <p class="mb-4 text-base leading-relaxed">
                    {{ $deskripsi_gangguan }}
                </p>

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
