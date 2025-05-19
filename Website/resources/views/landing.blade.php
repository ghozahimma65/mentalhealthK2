<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< HEAD
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
=======
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
      <div class="relative group cursor-pointer">
        <button class="flex items-center space-x-1 hover:underline">
          <span>Kontak</span>
          <i class="fas fa-chevron-down text-xs"></i>
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
  <main class="max-w-[1200px] mx-auto px-6 mt-6 md:mt-12">
    <section
      class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6"
    >
      <div class="max-w-xl md:max-w-lg">
        <h1
          class="text-[#0A1A4F] font-extrabold text-3xl md:text-4xl leading-[44px] mb-4 select-none"
        >
          Diagnosa Dini untuk<br />Kesehatan Mental Anda
        </h1>
        <p
          class="text-[#0A1A4F] font-semibold text-xs leading-5 mb-6 select-none max-w-[400px]"
        >
          Khawatir dengan kondisi kesehatan mental Anda? Alat bantu terpercaya
          kami memudahkan Anda untuk mengenali gejala, memahami kondisi
          emosional, dan mendapatkan dukungan kapan saja, di mana saja.
        </p>
        <div class="flex flex-wrap gap-4">
          <button
            type="button"
            class="bg-[#7A9CC6] text-white text-xs font-semibold px-4 py-2 rounded-md flex items-center space-x-2 select-none"
          >
            <span>Mulai Cek Kesehatan Mental</span>
            <i class="fas fa-arrow-right"></i>
          </button>
          <button
            type="button"
            class="border border-[#0A1A4F] text-[#0A1A4F] text-xs font-semibold px-4 py-2 rounded-md select-none"
          >
            Uduh Aplikasi Diagnosa
          </button>
        </div>
      </div>
      <div class="flex-shrink-0">
        <img
          src="{{ asset('assets/ilustrasions.png') }}"
          alt="Illustration"
          width="400"
          height="280"
          class="w-full max-w-[400px] h-auto select-none"
          draggable="false"
        />
      </div>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Diagnosa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    {{-- Tambahkan Font Awesome jika belum ada di navbar atau app.blade.php Anda --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F5F9FF]">

    {{-- Navbar --}}
    {{-- Pastikan Anda memiliki file resources/views/components/navbar.blade.php --}}
    @include('components.navbar')

    {{-- Hero Section --}}
    <main class="w-full min-h-screen px-6 py-32 md:py-150 bg-white">
        <section class="flex flex-col md:flex-row items-center justify-between gap-12 w-full h-full">
            <div class="w-full md:w-1/2">
                <h1 class="text-[#0A1A4F] font-extrabold text-4xl md:text-5xl leading-tight mb-6 select-none">
                    Diagnosa Dini untuk<br />Kesehatan Mental Anda
                </h1>
                <p class="text-[#0A1A4F] font-medium text-base leading-relaxed mb-8 max-w-[500px] select-none">
                    Khawatir dengan kondisi kesehatan mental Anda? Alat bantu terpercaya kami memudahkan Anda untuk mengenali gejala, memahami kondisi emosional, dan mendapatkan dukungan kapan saja, di mana saja.
                </p>
                <div class="flex flex-wrap gap-4">
                    {{-- Tombol ini mungkin perlu link ke halaman diagnosa Anda --}}
                    <a href="#" class="bg-[#7A9CC6] text-white text-sm font-semibold px-5 py-3 rounded-lg flex items-center gap-2 select-none">
                        <span>Mulai Cek Kesehatan Mental</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    {{-- Tombol ini mungkin perlu link ke halaman unduh --}}
                    <a href="#" class="border border-[#0A1A4F] text-[#0A1A4F] text-sm font-semibold px-5 py-3 rounded-lg select-none">
                        Unduh Aplikasi Diagnosa
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex justify-center">
                {{-- Pastikan path ke aset gambar Anda benar --}}
                <img src="{{ asset('assets/ilustrasions.png') }}" alt="Ilustrasi Kesehatan Mental" class="max-w-[500px] w-full h-auto select-none" draggable="false" />
            </div>
        </section>
    </main>

    {{-- Home Section (SISTEM PAKAR) --}}
    <section id="home" class="text-center py-8 px-4 bg-white">
        <h2 class="font-bold text-base md:text-lg max-w-md mx-auto text-[#0A1A4F]">
            SISTEM PAKAR
        </h2>
    </section>

    {{-- Dashboard Section (Kutipan) --}}
    <section id="dashboard" class="bg-black text-white px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <p class="font-bold text-lg md:text-xl max-w-3xl mx-auto leading-snug text-center">
                “Kami membuat Aplikasi Diagnosa sebagai proyek akhir Tahun untuk membantu teman-teman kami yang mungkin mengalami depresi untuk mengetahui tingkat depresi mereka dan menemukan solusi yang sesuai”
            </p>
        </div>

    </section>

  <main class="max-w-4xl mx-auto px-6 py-16">
    <h1 class="text-center text-[#000c3b] text-lg font-normal mb-10">
      Pertanyaan Yang Sering Diajukan - FAQ
    </h1>
    <section class="space-y-6">
      <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b]">
        Apa itu DepresiCheck?
      </div>
      <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b]">
        Siapa yang bisa mengakses DepresiCheck?
      </div>
      <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b]">
        Apakah hasil dari DepresiCheck dapat diandalkan?
      </div>
    </section>
  </main>
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
    {{-- Awal Seksi Unggulan Gangguan Mood --}}
    {{-- Seksi ini ditempatkan SETELAH Kutipan dan SEBELUM FAQ --}}
    @if(isset($featuredDisorder))
    <section class="py-12 md:py-16 bg-slate-50"> {{-- Anda bisa mengganti bg-slate-50 dengan bg-[#F5F9FF] jika ingin sama dengan body --}}
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0A1A4F]">Pelajari Lebih Lanjut Tentang</h2>
                <p class="text-slate-600 mt-2">Informasi singkat mengenai salah satu kondisi yang kami tangani.</p>
            </div>

            <div class="max-w-4xl mx-auto">
                {{-- Bagian Header Informasi Gangguan --}}
                <div class="bg-gray-100 p-4 md:p-6 rounded-t-lg shadow-md">
                    <h3 class="text-lg md:text-xl font-semibold text-[#0A1A4F]">
                        {{ $featuredDisorder['kode'] ?? 'PXXX' }} | {{ $featuredDisorder['nama_gangguan'] ?? 'Nama Gangguan Tidak Tersedia' }}
                    </h3>
                    @if(isset($featuredDisorder['kesimpulan']) && !empty($featuredDisorder['kesimpulan']))
                    <p class="mt-1 text-xs md:text-sm text-gray-700 italic">
                        {{ $featuredDisorder['kesimpulan'] }}
                    </p>
                    @endif
                </div>

                {{-- Kartu Konten Utama (Gambar dan Deskripsi Detail) --}}
                <div class="bg-white shadow-md rounded-b-lg p-6 md:p-8">
                    <div class="text-gray-700">
                        <h4 class="text-xl md:text-2xl font-semibold text-[#0A1A4F] mb-4 text-center">
                            {{ $featuredDisorder['nama_gangguan'] ?? 'Detail Gangguan' }}
                        </h4>

                        {{-- Gambar Ilustrasi --}}
                        @if(isset($featuredDisorder['path_gambar']) && file_exists(public_path($featuredDisorder['path_gambar'])))
                            <img src="{{ asset($featuredDisorder['path_gambar']) }}" alt="Ilustrasi {{ $featuredDisorder['nama_gangguan'] ?? 'Gangguan' }}" class="w-full max-w-sm mx-auto h-auto rounded-lg shadow mb-6 border border-gray-200">
                        @else
                            <div class="text-center text-red-500 my-4 p-3 bg-red-100 rounded-md">
                                <i class="fas fa-image mr-2"></i>Gambar ilustrasi tidak ditemukan.
                            </div>
                        @endif

                        {{-- Deskripsi Gangguan --}}
                        <div class="prose max-w-none"> {{-- Kelas 'prose' dari Tailwind untuk styling teks dasar --}}
                            @if(isset($featuredDisorder['deskripsi_gangguan_intro']) && !empty($featuredDisorder['deskripsi_gangguan_intro']))
                            <p class="mb-3 text-base leading-relaxed">
                                {{ $featuredDisorder['deskripsi_gangguan_intro'] }}
                            </p>
                            @endif

                            @if(!empty($featuredDisorder['poin_utama_deskripsi']))
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($featuredDisorder['poin_utama_deskripsi'] as $poin)
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

                        {{-- Tombol Baca Selengkapnya --}}
                        <div class="mt-6 text-center">
                            <a href="{{ $featuredDisorder['link_detail'] ?? '#' }}"
                               class="inline-block bg-[#7A9CC6] text-white text-sm font-semibold px-5 py-3 rounded-lg flex items-center justify-center gap-2 select-none hover:bg-opacity-80 transition duration-300">
                               <span>Baca Selengkapnya</span>
                               <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    {{-- Akhir Seksi Unggulan Gangguan Mood --}}

    {{-- FAQ Section --}}
    <section class="max-w-4xl mx-auto px-6 py-16" id="faq">
        <h2 class="text-center text-[#000c3b] text-lg font-normal mb-10">
            Pertanyaan Yang Sering Diajukan - FAQ
        </h2>
        <div class="space-y-6">
            <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b] rounded-md shadow">
                Apa itu Diagnosa?
            </div>
            <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b] rounded-md shadow">
                Siapa yang bisa mengakses Diagnosa
            </div>
            <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b] rounded-md shadow">
                Apakah hasil dari Diagnosa dapat diandalkan?
            </div>
        </div>
>>>>>>> f2f6d6f079a3265064b6494a3d934b03d7a964ac
    </section>

    <script>
<<<<<<< HEAD
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
=======
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>

>>>>>>> f2f6d6f079a3265064b6494a3d934b03d7a964ac
</body>
</html>