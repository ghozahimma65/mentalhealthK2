<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Diagnosa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-[#F5F9FF]">

  {{-- Navbar --}}
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
          <button type="button" class="bg-[#7A9CC6] text-white text-sm font-semibold px-5 py-3 rounded-lg flex items-center gap-2 select-none">
            <span>Mulai Cek Kesehatan Mental</span>
            <i class="fas fa-arrow-right"></i>
          </button>
          <button type="button" class="border border-[#0A1A4F] text-[#0A1A4F] text-sm font-semibold px-5 py-3 rounded-lg select-none">
            Unduh Aplikasi Diagnosa
          </button>
        </div>
      </div>
      <div class="w-full md:w-1/2 flex justify-center">
        <img src="{{ asset('assets/ilustrasions.png') }}" alt="Illustration" class="max-w-[500px] w-full h-auto select-none" draggable="false" />
      </div>
    </section>
  </main>

  {{-- Home Section --}}
  <main id="home" class="text-center py-8 px-4">
    <h1 class="font-bold text-base md:text-lg max-w-md mx-auto">
      <br/> SISTEM PAKAR
    </h1>
  </main>

  {{-- Dashboard Section --}}
  <section id="dashboard" class="bg-black text-white px-6 py-12 max-w-4xl mx-auto">
    <p class="font-bold text-lg md:text-xl max-w-3xl mx-auto leading-snug">
      “Kami membuat DepresiCheck sebagai proyek akhir Tahun untuk membantu teman-teman kami yang mungkin mengalami depresi untuk mengetahui tingkat depresi mereka dan menemukan solusi yang sesuai”
    </p>
  </section>

  {{-- FAQ Section --}}
  <main class="max-w-4xl mx-auto px-6 py-16" id="faq">
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

  {{-- Menu & Cek Diagnosa Section --}}
  <section id="menu" class="hidden">
    <!-- Content for Menu -->
  </section>
  <section id="cek-diagnosa" class="hidden">
    <!-- Content for Cek Diagnosa -->
  </section>

  {{-- Smooth Scroll Script --}}
  <script>
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

</body>
</html>
