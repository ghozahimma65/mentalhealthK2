<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Website Diagnosa')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>body { font-family: "Poppins", sans-serif; }</style>
</head>
<body class="bg-[#EDF6F9] text-[#2C3E70] min-h-screen">

    {{-- HEADER PUBLIK --}}
    <header class="bg-white py-4 shadow-md">
        <div class="container mx-auto px-4">
            <a href="/" class="font-bold text-xl text-[#2C3E70]">Diagnosa</a>
            {{-- Tambahkan navigasi publik Anda di sini jika ada --}}
        </div>
    </header>

    <main class="py-8">
        {{-- KONTEN UTAMA --}}
        <div class="container mx-auto">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER PUBLIK --}}
    <footer class="bg-gray-100 py-4 text-center text-gray-600 text-sm">
        <div class="container mx-auto">
            &copy; {{ date('Y') }} Website Diagnosa
        </div>
    </footer>

</body>
</html>