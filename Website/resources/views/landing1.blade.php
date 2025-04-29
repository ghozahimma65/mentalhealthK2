<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Diagnosa FAQ
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: 'Inter', sans-serif;
    }
  </style>
 </head>
 <body class="bg-white text-[#000c3b]">
  <header class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
   <div class="flex items-center space-x-3">
    <div class="w-10 h-10 rounded-lg bg-[#7ea3b8] flex items-center justify-center">
     <img alt="Sad face icon in white on blue rounded square background" class="w-6 h-6" height="24" src="https://storage.googleapis.com/a1aa/image/12cefd0a-a8d8-49cc-63b3-494c902b85a2.jpg" width="24"/>
    </div>
    <span class="text-[#7ea3b8] text-xl font-semibold drop-shadow-[0_1px_1px_rgba(126,163,184,0.7)] select-none">
     Diagnosa
    </span>
   </div>
   <nav class="hidden md:flex items-center space-x-6 font-semibold text-xs text-[#000c3b]">
    <a class="hover:underline" href="#">
     Dashnoard
    </a>
    <a class="hover:underline" href="#">
     Menu
    </a>
    <a class="hover:underline" href="#">
     Cek Diagnosa
    </a>
    <div class="relative group">
     <button class="flex items-center space-x-1 hover:underline">
      <span>
       Kontak
      </span>
      <i class="fas fa-chevron-down text-[8px]">
      </i>
     </button>
    </div>
   </nav>
   <button class="bg-[#7ea3b8] text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-[#6a8ea0] transition">
    Login
   </button>
  </header>
  <nav id="stickyMenu" class="hidden md:flex fixed top-[56px] left-0 right-0 bg-white border-b border-gray-200 z-50 px-6 py-3 space-x-6 font-semibold text-xs text-[#000c3b] shadow-md">
   <a class="hover:underline" href="#">
    Dashnoard
   </a>
   <a class="hover:underline" href="#">
    Menu
   </a>
   <a class="hover:underline" href="#">
    Cek Diagnosa
   </a>
   <div class="relative group">
    <button class="flex items-center space-x-1 hover:underline">
     <span>
      Kontak
     </span>
     <i class="fas fa-chevron-down text-[8px]">
     </i>
    </button>
   </div>
  </nav>
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
   // Show sticky menu on scroll past header height
    const stickyMenu = document.getElementById('stickyMenu');
    const headerHeight = document.querySelector('header').offsetHeight;

    window.addEventListener('scroll', () => {
      if(window.scrollY > headerHeight) {
        stickyMenu.classList.remove('hidden');
      } else {
        stickyMenu.classList.add('hidden');
      }
    });
  </script>
 </body>
</html>