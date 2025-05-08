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
