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
    <img alt="Diagnosa app logo icon with a blue background and white face icon" class="w-10 h-10" height="40" src="https://storage.googleapis.com/a1aa/image/b62cdc83-1e60-4477-b20b-23fdff106722.jpg" width="40"/>
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
