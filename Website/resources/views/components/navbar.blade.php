
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
    href="{{ route('admin.dashboard') }}"
    class="bg-[#7A9CC6] text-white text-sm font-semibold px-4 py-2 rounded-md select-none"
  >
    Dashboard Admin
  </a>


{{-- Diasumsikan ini adalah isi dari resources/views/components/navbar.blade.php --}}
<nav class="bg-white shadow-md">
  <div class="container mx-auto px-6 py-3 flex justify-between items-center">
      <div class="flex items-center">
          <div class="bg-[#7A9CC6] p-2 rounded-full mr-3"> {{-- Warna disesuaikan dengan logo Anda --}}
              {{-- Ganti dengan SVG logo Anda atau ikon yang sesuai --}}
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
          </div>
          <a class="text-xl font-semibold text-[#0A1A4F]" href="{{ url('/') }}">Diagnosa</a>
      </div>
      <div class="flex items-center space-x-4 md:space-x-6">
          <a href="{{ route('landing') }}" class="text-[#0A1A4F] hover:text-[#7A9CC6] transition duration-150">Beranda</a>
          
          {{-- Jika Dashboard memerlukan login, Anda bisa menambah @auth directive --}}
          @auth
              <a href="{{ route('dashboard') }}" class="text-[#0A1A4F] hover:text-[#7A9CC6] transition duration-150">Dashboard</a>
          @endauth

          {{-- INI BAGIAN YANG PERLU DIPERHATIKAN --}}
          <a href="{{ route('diagnosa.cek') }}" class="text-[#0A1A4F] hover:text-[#7A9CC6] transition duration-150">Cek Diagnosa</a>
          
          <a href="{{ url('/#faq') }}" class="text-[#0A1A4F] hover:text-[#7A9CC6] transition duration-150">FAQ</a>
          <a href="#" class="text-[#0A1A4F] hover:text-[#7A9CC6] transition duration-150">Kontak</a>
          
          @guest
              <a href="{{ route('login') }}" class="bg-[#7A9CC6] text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-opacity-80 transition duration-150">Login</a>
          @else
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a href="{{ route('logout') }}"
                     onclick="event.preventDefault(); this.closest('form').submit();"
                     class="bg-red-500 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-600 transition duration-150">
                      Logout
                  </a>
              </form>
          @endguest
      </div>
  </div>
</nav>
