<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Diagnosa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
        rel="stylesheet"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F5F9FF]">
    <header
        class="flex items-center justify-between px-6 py-4 max-w-[1200px] mx-auto"
    >
        <div class="flex items-center space-x-2">
            <div class="bg-[#7A9CC6] rounded-lg p-2">
                <img
                    src="{{ asset('assets/logo.png') }}"
                    alt="Gambar logo Diagnosa"
                    width="32"
                    height="32"
                    class="block"
                />
            </div>
            <span
                class="text-[#2F4F7C] font-semibold text-xl leading-6 select-none drop-shadow-[1px_1px_1px_rgba(0,0,0,0.25)]"
                >Diagnosa</span
            >
        </div>
        <nav
            class="hidden md:flex items-center space-x-8 text-[#0A1A4F] font-semibold text-sm leading-5 select-none"
        >
            <a href="#" class="hover:underline">Dashboard</a>
            <a href="#" class="hover:underline">Menu</a>
            <a href="#" class="hover:underline">Cek Diagnosa</a>
            <div class="relative cursor-pointer group">
                <button class="flex items-center space-x-1 hover:underline">
                    <span>Kontak</span>
                    <i class="text-xs fas fa-chevron-down"></i>
                </button>
            </div>
            <button
                type="button"
                class="bg-[#7A9CC6] text-white text-sm font-semibold px-4 py-2 rounded-md select-none"
                onclick="window.location.href='{{ route('login') }}'"
            >
                Login
            </button>
        </nav>
    </header>
    <main class="min-h-screen max-w-[1200px] mx-auto px-6 mt-6 md:mt-12">
        <section
            class="flex flex-col items-center justify-between h-full gap-8 md:flex-row md:items-start"
        >
            <div class="max-w-xl md:max-w-lg">
                <h1
                    class="text-[#0A1A4F] font-extrabold text-4xl md:text-5xl leading-[50px] mb-6 select-none"
                >
                    Diagnosa Dini untuk<br />Kesehatan Mental Anda
                </h1>
                <p
                    class="text-[#0A1A4F] font-semibold text-sm md:text-base leading-relaxed mb-8 select-none max-w-[450px]"
                >
                    Khawatir dengan kondisi kesehatan mental Anda? Alat bantu terpercaya
                    kami memudahkan Anda untuk mengenali gejala, memahami kondisi
                    emosional, dan mendapatkan dukungan kapan saja, di mana saja.
                </p>
                <div class="flex flex-wrap gap-4">
                    <button
                        type="button"
                        class="bg-[#7A9CC6] text-white text-sm md:text-base font-semibold px-6 py-3 rounded-md flex items-center space-x-3 select-none"
                    >
                        <span>Mulai Cek Kesehatan Mental</span>
                        <i class="text-base fas fa-arrow-right"></i>
                    </button>
                    <button
                        type="button"
                        class="border border-[#0A1A4F] text-[#0A1A4F] text-sm md:text-base font-semibold px-6 py-3 rounded-md select-none"
                    >
                        Unduh Aplikasi Diagnosa
                    </button>
                </div>
            </div>
            <div class="flex-shrink-0 w-full md:w-auto max-w-[500px]">
                <img
                    src="{{ asset('assets/ilustrasions.png') }}"
                    alt="Illustration"
                    class="w-full h-auto select-none"
                    draggable="false"
                />
            </div>
        </section>

    <section class="max-w-6xl py-16 mx-auto">
    <h1 class="text-center text-[#000c3b] text-lg font-normal mb-10">
        Pertanyaan Yang Sering Diajukan - FAQ
    </h1>
    <div class="space-y-6">
        <details class="bg-[#f0f7fa] px-6 py-4 text-xs text-[#000c3b]">
            <summary class="flex items-center justify-between cursor-pointer">
                <strong>Apa itu DepresiCheck?</strong>
                <span class="faq-arrow">&#9660;</span>
            </summary>
            <p class="mt-2">DepresiCheck adalah sebuah alat skrining mandiri yang dirancang untuk membantu Anda mengenali kemungkinan adanya gejala depresi. Alat ini menggunakan serangkaian pertanyaan standar yang umum digunakan dalam penilaian kesehatan mental. Perlu diingat bahwa DepresiCheck bukanlah diagnosis dan tidak menggantikan evaluasi profesional dari tenaga kesehatan mental.</p>
        </details>
        <details class="bg-[#f0f7fa] px-6 py-4 text-xs text-[#000c3b]">
            <summary class="flex items-center justify-between cursor-pointer">
                <strong>Siapa yang bisa mengakses DepresiCheck?</strong>
                <span class="faq-arrow">&#9660;</span>
            </summary>
            <p class="mt-2">DepresiCheck dapat diakses oleh siapa saja yang ingin melakukan pemeriksaan awal terhadap kemungkinan gejala depresi. Alat ini bersifat terbuka dan dapat digunakan tanpa batasan usia maupun latar belakang.</p>
        </details>
        <details class="bg-[#f0f7fa] px-6 py-4 text-xs text-[#000c3b]">
            <summary class="flex items-center justify-between cursor-pointer">
                <strong>Apakah hasil dari DepresiCheck dapat diandalkan?</strong>
                <span class="faq-arrow">&#9660;</span>
            </summary>
            <p class="mt-2">Hasil dari DepresiCheck memberikan gambaran awal tentang kemungkinan adanya gejala depresi berdasarkan jawaban yang Anda berikan. Meskipun dirancang berdasarkan kuesioner standar, hasil ini tidak dapat dianggap sebagai diagnosis pasti. Untuk diagnosis dan penanganan yang akurat, sangat disarankan untuk berkonsultasi dengan psikolog, psikiater, atau tenaga kesehatan mental profesional lainnya.</p>
        </details>
    </div>
</section>
    </main>

    <section class="max-w-4xl px-6 py-12 mx-auto text-center text-white bg-black">
        <p class="max-w-3xl mx-auto text-lg font-bold leading-snug md:text-xl">
            “Kami membuat DepresiCheck sebagai proyek akhir Tahun untuk membantu teman-teman kami yang mungkin mengalami depresi untuk mengetahui tingkat depresi mereka dan menemukan solusi yang sesuai”
        </p>
    </section>

    <section class="px-4 py-8 text-center">
        - Hubungi kami, kapanpun saat anda merasa membutuhkan teman bercerita, kami selalu ada untuk anda -
    </section>

    <script>
        // Pastikan tidak ada ID stickyMenu ganda jika file ini digabung atau di-include
        // Jika ada, pastikan script ini hanya dieksekusi sekali atau gunakan ID yang unik
        const stickyMenu = document.getElementById('stickyMenu'); // Jika ada elemen dengan ID ini
        if (stickyMenu) {
            const header = document.querySelector('header');
            if (header) {
                const headerHeight = header.offsetHeight;
                window.addEventListener('scroll', () => {
                    if (window.scrollY > headerHeight) {
                        stickyMenu.classList.remove('hidden');
                    } else {
                        stickyMenu.classList.add('hidden');
                    }
                });
            }
        }
    </script>
</body>
</html>