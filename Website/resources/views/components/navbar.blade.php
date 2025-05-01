<header class="fixed top-0 left-0 w-full bg-[#F5F9FF] z-50 shadow-md">
  <div class="flex items-center justify-between px-6 py-4 max-w-[1200px] mx-auto">
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
    >
      Diagnosa
    </span>
  </div>
  <nav
    class="hidden md:flex items-center space-x-8 text-[#0A1A4F] font-semibold text-sm leading-5 select-none"
  >
    <a href="#home" class="hover:underline">Beranda</a>
    <a href="#dashboard" class="hover:underline">Dashboard</a>
    <a href="#cek-diagnosa" class="hover:underline">Cek Diagnosa</a>
    <a href="#faq" class="hover:underline">FAQ</a>
    <a href="#kontak" class="hover:underline">Kontak</a>
    <a
    href="/login"
    class="bg-[#7A9CC6] text-white text-sm font-semibold px-4 py-2 rounded-md select-none"
    >
    Login
    </a>

  </nav>
</header>
