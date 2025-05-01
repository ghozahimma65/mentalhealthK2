<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Dashboard Admin
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: "Poppins", sans-serif;
    }
  </style>
 </head>
 <body class="bg-[#EDF6F9] text-[#2C3E70] min-h-screen">
  <header class="flex items-center justify-between px-6 py-3 bg-white border-b border-gray-200">
   <div class="flex items-center space-x-2">
    <img alt="Diagnosa app logo icon with a blue background and white face icon" class="w-10 h-10" height="40" src="{{ asset('assets/logo.png') }}" width="40"/>
    <span class="font-semibold text-[#2C3E70] text-lg select-none">
     Dashboard
    </span>
   </div>
   <button aria-label="Toggle menu" class="lg:hidden flex flex-col justify-center space-y-1.5">
    <span class="block w-8 h-1 bg-[#2C3E70] rounded">
    </span>
    <span class="block w-8 h-1 bg-[#2C3E70] rounded">
    </span>
    <span class="block w-8 h-1 bg-[#2C3E70] rounded">
    </span>
   </button>
   <form aria-label="Site search" class="hidden md:flex items-center bg-[#EDF6F9] rounded px-3 py-1.5 w-[280px]" role="search">
    <input class="bg-transparent placeholder:text-[#7D7D7D] font-semibold text-[#2C3E70] text-sm focus:outline-none flex-grow" placeholder="Search" type="search"/>
    <button aria-label="Search" type="submit">
     <i class="fas fa-search text-[#2C3E70]">
     </i>
    </button>
   </form>
   <div class="flex items-center space-x-6">
    <button aria-label="Notifications" class="relative text-[#2C3E70] text-xl">
     <i class="fas fa-bell">
     </i>
     <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center">
      1
     </span>
    </button>
    <button aria-label="Messages" class="text-[#2C3E70] text-xl">
     <i class="far fa-comment">
     </i>
    </button>
    <div class="flex items-center space-x-2 cursor-pointer select-none">
     <img alt="User profile picture of a cat with gray and white fur" class="w-10 h-10 rounded-full object-cover" height="40" src="https://storage.googleapis.com/a1aa/image/f5304d33-f998-4d3c-9ed4-20275f507afb.jpg" width="40"/>
     <span class="font-semibold text-[#7D7D7D] text-base">
      aya
     </span>
    </div>
   </div>
  </header>
  <main class="flex min-h-[calc(100vh-56px)]">
   <nav aria-label="Primary Navigation" class="hidden md:flex flex-col bg-white w-56 border-r border-gray-200 px-6 py-8 select-none">
    <a class="mb-4 font-semibold text-[#2C3E70] text-base bg-[#EDF6F9] rounded px-2 py-1.5" href="#">
     Dashboard
    </a>
    <span class="text-[#B9C6D9] font-semibold text-xs mb-2 select-none">
     Pengetahuan
    </span>
    <a class="mb-3 font-semibold text-[#2C3E70] text-base hover:underline" href="#">
     Diagnosa
    </a>
    <a class="mb-3 font-semibold text-[#2C3E70] text-base hover:underline" href="#">
     Gejala
    </a>
    <a class="mb-3 font-semibold text-[#2C3E70] text-base hover:underline" href="#">
     Depresi
    </a>
    <a class="mb-6 font-semibold text-[#2C3E70] text-base hover:underline" href="#">
     Hasil Diagnosa
    </a>
    <span class="text-[#B9C6D9] font-semibold text-xs mb-2 select-none">
     Pengaturan
    </span>
    <a class="mb-3 font-semibold text-[#2C3E70] text-base hover:underline" href="#">
     Admin
    </a>
    <a class="font-semibold text-[#2C3E70] text-base hover:underline" href="#">
     Logout
    </a>
   </nav>
   <section class="flex-grow p-8">
    <h1 class="text-2xl font-bold mb-1">
     Dashboard
    </h1>
    <div class="flex items-center space-x-1 mb-8">
     <span class="text-[#B9C6D9] font-semibold text-sm select-none">
      Admin
     </span>
     <span class="font-semibold text-[#2C3E70] text-sm">
      / Tambah Admin
     </span>
    </div>
    <form autocomplete="off" class="max-w-3xl space-y-6" novalidate="">
     <div class="flex items-center space-x-4">
      <label class="w-40 font-semibold text-[#2C3E70] text-sm select-none" for="name">
       Nama :
      </label>
      <input class="flex-grow bg-white border border-transparent focus:border-[#2C3E70] rounded px-4 py-2 text-[#2C3E70] text-base" id="name" type="text"/>
     </div>
     <div class="flex items-center space-x-4">
      <label class="w-40 font-semibold text-[#2C3E70] text-sm select-none" for="email">
       Email Address :
      </label>
      <input class="flex-grow bg-white border border-transparent focus:border-[#2C3E70] rounded px-4 py-2 text-[#2C3E70] text-base" id="email" type="email"/>
     </div>
     <div class="flex items-center space-x-4">
      <label class="w-40 font-semibold text-[#2C3E70] text-sm select-none" for="password">
       Password :
      </label>
      <input class="flex-grow bg-white border border-transparent focus:border-[#2C3E70] rounded px-4 py-2 text-[#2C3E70] text-base" id="password" type="password"/>
     </div>
     <div class="flex items-center space-x-4">
      <label class="w-40 font-semibold text-[#2C3E70] text-sm select-none" for="confirm-password">
       Confirm Password :
      </label>
      <input class="flex-grow bg-white border border-transparent focus:border-[#2C3E70] rounded px-4 py-2 text-[#2C3E70] text-base" id="confirm-password" type="password"/>
     </div>
     <div class="flex items-center space-x-4">
      <label class="w-40 text-[#B9C6D9] text-xs select-none">
       Frame
      </label>
      <button class="bg-[#5B8FCF] text-white font-semibold text-xs rounded-full px-5 py-2" type="submit">
       Register
      </button>
     </div>
    </form>
   </section>
  </main>
 </body>
</html>



<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Dashboard
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: 'Inter', sans-serif;
    }
  </style>
 </head>
 <body class="bg-[#EDF6F9] text-[#1D3557]">
  <header class="flex items-center justify-between px-4 py-3 bg-white shadow-sm">
   <div class="flex items-center space-x-2">
    <img alt="Diagnosa logo with sad face icon in blue square" class="w-8 h-8" height="32" src="https://storage.googleapis.com/a1aa/image/57103051-bc74-43f8-5562-782c09968752.jpg" width="32"/>
    <span class="font-semibold text-[#1D3557] text-base md:text-lg">
     Dashboard
    </span>
    <button aria-label="Menu" class="ml-4 md:hidden focus:outline-none">
     <i class="fas fa-bars text-[#1D3557] text-2xl">
     </i>
    </button>
   </div>
   <form class="hidden md:flex items-center bg-[#E6E6E6] rounded px-2 py-1 w-[220px] md:w-[280px]">
    <input class="bg-[#E6E6E6] text-[#1D3557] placeholder-[#7D7D7D] text-sm md:text-base focus:outline-none flex-grow" placeholder="Search" type="search"/>
    <button class="text-[#1D3557] ml-2" type="submit">
     <i class="fas fa-search">
     </i>
    </button>
   </form>
   <div class="flex items-center space-x-4">
    <button aria-label="Notifications" class="relative text-[#1D3557] text-xl focus:outline-none">
     <i class="fas fa-bell">
     </i>
     <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-semibold rounded-full w-4 h-4 flex items-center justify-center">
      1
     </span>
    </button>
    <button aria-label="Messages" class="text-[#1D3557] text-xl focus:outline-none">
     <i class="fas fa-comment-alt">
     </i>
    </button>
    <div class="flex items-center space-x-2">
     <img alt="Profile picture of a cat face" class="w-8 h-8 rounded-full object-cover" height="32" src="https://storage.googleapis.com/a1aa/image/dbcc4a11-403c-44d4-5e8b-c580d88e317a.jpg" width="32"/>
     <span class="text-[#7D7D7D] font-semibold text-sm md:text-base">
      aya
     </span>
    </div>
   </div>
  </header>
  <main class="flex min-h-[calc(100vh-56px)]">
   <nav aria-label="Sidebar Navigation" class="flex flex-col border-r-4 border-[#1D4ED8] bg-white w-48 md:w-56 py-6 px-4 select-none">
    <span class="text-[#1D4ED8] font-semibold text-sm md:text-base mb-1 px-2 py-1 rounded bg-[#D6E4FF]">
     Dashboard
    </span>
    <span class="text-[#B0B0B0] text-xs md:text-sm mb-3 px-2">
     Pengetahuan
    </span>
    <a class="font-semibold text-[#1D3557] text-sm md:text-base mb-3 px-2 hover:underline" href="#">
     Diagnosa
    </a>
    <a class="font-semibold text-[#1D3557] text-sm md:text-base mb-3 px-2 hover:underline" href="#">
     Gejala
    </a>
    <a class="font-semibold text-[#1D3557] text-sm md:text-base mb-3 px-2 hover:underline" href="#">
     Depresi
    </a>
    <a class="font-semibold text-[#1D3557] text-sm md:text-base mb-6 px-2 hover:underline" href="#">
     Hasil Diagnosa
    </a>
    <span class="text-[#B0B0B0] text-xs md:text-sm mb-3 px-2">
     Pengaturan
    </span>
    <a class="font-semibold text-[#1D3557] text-sm md:text-base mb-3 px-2 hover:underline" href="#">
     Admin
    </a>
    <a class="font-semibold text-[#1D3557] text-sm md:text-base px-2 hover:underline" href="#">
     Logout
    </a>
   </nav>
   <section class="flex-1 p-6">
    <h1 class="font-bold text-[#1D3557] text-xl md:text-2xl mb-1">
     Dashboard
    </h1>
    <p class="text-[#7D7D7D] text-xs md:text-sm mb-6">
     Admin /
     <span class="font-semibold">
      Daftar Admin
     </span>
    </p>
    <article aria-label="Admin user card" class="bg-[#FFF8F8] rounded-md p-4 mb-4 flex items-start space-x-4 max-w-md">
     <i class="fas fa-user-circle text-[#1D3557] text-lg mt-1">
     </i>
     <div>
      <p class="font-semibold text-[#1D3557] text-sm md:text-base mb-1">
       Admin
      </p>
      <a class="text-[#A3AED0] text-xs md:text-sm hover:underline" href="mailto:ayayaya@gmail.com">
       ayayaya@gmail.com
      </a>
     </div>
    </article>
    <article aria-label="Admin user card" class="bg-[#FFF8F8] rounded-md p-4 mb-4 flex items-start space-x-4 max-w-md">
     <i class="fas fa-user-circle text-[#1D3557] text-lg mt-1">
     </i>
     <div>
      <p class="font-semibold text-[#1D3557] text-sm md:text-base mb-1">
       Admin
      </p>
      <a class="text-[#A3AED0] text-xs md:text-sm hover:underline" href="mailto:ghozzzzzngantuk@gmail.com">
       ghozzzzzngantuk@gmail.com
      </a>
     </div>
    </article>
    <article aria-label="Admin user card" class="bg-[#FFF8F8] rounded-md p-4 mb-4 flex items-start space-x-4 max-w-md">
     <i class="fas fa-user-circle text-[#1D3557] text-lg mt-1">
     </i>
     <div>
      <p class="font-semibold text-[#1D3557] text-sm md:text-base mb-1">
       Admin
      </p>
      <a class="text-[#A3AED0] text-xs md:text-sm hover:underline" href="mailto:meongdyohh@gmail.com">
       meongdyohh@gmail.com
      </a>
     </div>
    </article>
    <article aria-label="Admin user card" class="bg-[#FFF8F8] rounded-md p-4 mb-4 flex items-start space-x-4 max-w-md">
     <i class="fas fa-user-circle text-[#1D3557] text-lg mt-1">
     </i>
     <div>
      <p class="font-semibold text-[#1D3557] text-sm md:text-base mb-1">
       Admin
      </p>
      <a class="text-[#A3AED0] text-xs md:text-sm hover:underline" href="mailto:tititititi@gmail.com">
       tititititi@gmail.com
      </a>
     </div>
    </article>
   </section>
  </main>
 </body>
</html>
