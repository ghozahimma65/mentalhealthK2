<<<<<<< HEAD
=======

>>>>>>> f2f6d6f079a3265064b6494a3d934b03d7a964ac
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
<<<<<<< HEAD

    {{-- HEADER --}}
    @include('layouts.main')
=======

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
>>>>>>> f2f6d6f079a3265064b6494a3d934b03d7a964ac

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
