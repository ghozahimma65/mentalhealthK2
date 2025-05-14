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
  <main class="max-w-[1200px] mx-auto px-6 mt-6 md:mt-12">
    <section
      class="flex flex-col items-center justify-between gap-6 md:flex-row md:items-start"
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
    </section>
  </main>

  <main class="max-w-4xl px-6 py-16 mx-auto">
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
</body>
</html>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Diagnosa
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 </head>



 <body class="bg-white">
  <main class="px-4 py-8 text-center">
   <h1 class="max-w-md mx-auto text-base font-bold md:text-lg">
    -Projek akhir Semester Mata Kuliah-
    <br/>
    SISTEM PAKAR
   </h1>
  </main>
  <section class="max-w-4xl px-6 py-12 mx-auto text-white bg-black">
   <p class="max-w-3xl mx-auto text-lg font-bold leading-snug md:text-xl">
    “Kami membuat DepresiCheck sebagai proyek akhir Tahun untuk membantu teman-teman kami yang mungkin mengalami depresi untuk mengetahui tingkat depresi mereka dan menemukan solusi yang sesuai”
   </p>
  </section>
 </body>
</html>



  <main class="px-4 py-8 text-center">
    -Hubungi kami, kapanpun saat anda merasa membutuhkan teman bercerita, kami selalu ada untuk anda-
    <br/>
    </section>
 </body>
</html>