<footer class="px-4 py-8 mt-12 text-white bg-gray-800 sm:px-6 lg:px-8">
    <div class="grid max-w-screen-xl grid-cols-1 gap-8 mx-auto md:grid-cols-4">
        {{-- Kolom 1: Logo & Deskripsi Singkat --}}
        <div class="flex flex-col items-center col-span-1 text-center md:col-span-1 md:items-start md:text-left">
            <div class="flex items-center mb-3 space-x-2">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo Diagnosa" width="32" height="32" class="block">
                <span class="text-xl font-semibold text-blue-300">Diagnosa App</span>
            </div>
            <p class="text-sm leading-relaxed text-gray-400">
                Platform Anda untuk memahami dan mendukung kesehatan mental. Kami percaya bahwa setiap langkah kecil menuju kesejahteraan adalah penting.
            </p>
        </div>

        {{-- Kolom 2: Navigasi Cepat --}}
        <div class="col-span-1 text-center md:col-span-1 md:text-left">
            <h3 class="mb-4 text-lg font-semibold text-white">Navigasi Cepat</h3>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('dashboard') }}" class="transition duration-200 hover:text-blue-300">Beranda</a></li>
                <li><a href="{{ route('diagnosis.form') }}" class="transition duration-200 hover:text-blue-300">Mulai Diagnosis</a></li>
                @auth
                    <li><a href="{{ route('predictions.history') }}" class="transition duration-200 hover:text-blue-300">Riwayat Saya</a></li>
                    {{-- Asumsi Anda memiliki rute untuk profil --}}
                    <li><a href="#" class="transition duration-200 hover:text-blue-300">Profil Saya</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="transition duration-200 hover:text-blue-300">Login</a></li>
                    <li><a href="{{ route('register') }}" class="transition duration-200 hover:text-blue-300">Daftar</a></li>
                @endauth
            </ul>
        </div>

        {{-- Kolom 3: Sumber Daya Kesehatan Mental --}}
        <div class="col-span-1 text-center md:col-span-1 md:text-left">
            <h3 class="mb-4 text-lg font-semibold text-white">Sumber Daya</h3>
            <ul class="space-y-2 text-sm text-gray-400">
                {{-- Menggunakan route admin.articles.index atau public articles.show jika ada --}}
                <li><a href="#" class="transition duration-200 hover:text-blue-300">Baca Artikel</a></li>
                <li><a href="https://hellosehat.com/mental/" target="_blank" rel="noopener noreferrer" class="transition duration-200 hover:text-blue-300">Hello Sehat <i class="ml-1 text-xs fas fa-external-link-alt"></i></a></li>
                <li><a href="https://www.intothelightid.org/" target="_blank" rel="noopener noreferrer" class="transition duration-200 hover:text-blue-300">Into The Light <i class="ml-1 text-xs fas fa-external-link-alt"></i></a></li>
                <li><a href="https://www.alodokter.com/psikologi" target="_blank" rel="noopener noreferrer" class="transition duration-200 hover:text-blue-300">Alodokter Psikologi <i class="ml-1 text-xs fas fa-external-link-alt"></i></a></li>
            </ul>
        </div>

        {{-- Kolom 4: Kontak & Dukungan --}}
        <div class="col-span-1 text-center md:col-span-1 md:text-left">
            <h3 class="mb-4 text-lg font-semibold text-white">Hubungi Kami</h3>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><i class="mr-2 fas fa-envelope"></i> support@diagnosaapp.com</li>
                <li><i class="mr-2 fas fa-phone"></i> +62 812-345-6789</li>
                <li><i class="mr-2 fas fa-map-marker-alt"></i> Jember, East Java, Indonesia</li>
                <li>
                    <a href="#" class="inline-block px-4 py-2 mt-3 text-sm font-medium text-white transition duration-200 bg-blue-600 rounded-md hover:bg-blue-700">
                        Kirim Pesan <i class="ml-2 fas fa-paper-plane"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <hr class="my-8 border-gray-700">

    {{-- Baris Bawah: Copyright & Pesan Penyemangat --}}
    <div class="text-sm text-center text-gray-500">
        <p>&copy; {{ date('Y') }} Diagnosa App. Semua hak dilindungi.</p>
        <p class="mt-2">
            "Prioritaskan kesehatan mental Anda. Anda berharga." <span class="text-blue-300">💖</span>
        </p>
    </div>
</footer>