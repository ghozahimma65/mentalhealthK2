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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: 'Inter', sans-serif;
    }
  </style>
 </head>
 <body class="bg-[#e8f0f4] text-[#1e2a4a] min-h-screen">
  <div class="flex h-screen">
   <!-- Sidebar -->
   <aside class="bg-white w-56 flex flex-col border-r border-gray-200">
    <div class="flex items-center justify-center border-b border-gray-200 p-2">
     <div class="w-12 h-12 border-2 border-blue-500 rounded flex flex-col items-center justify-center text-blue-500 text-xs font-semibold">
        <img alt="..." class="mb-1" height="24" src="{{ asset('assets/logo.png') }}" width="30"/>
        Diagnosa
     </div>
    </div>
    <nav class="flex flex-col mt-4 px-4 space-y-1 text-sm font-semibold">
     <a class="block py-2 px-3 rounded bg-[#e6f2f7] text-blue-400 font-bold" href="#">
      Dashboard
     </a>
     <span class="text-gray-300 font-normal mt-4 mb-1">
      Pengetahuan
     </span>
     <a class="block py-2 px-3 rounded hover:bg-gray-100" href="#">
      Diagnosa
     </a>
     <a class="block py-2 px-3 rounded hover:bg-gray-100" href="#">
      Gejala
     </a>
     <a class="block py-2 px-3 rounded hover:bg-gray-100" href="#">
      Depresi
     </a>
     <a class="block py-2 px-3 rounded hover:bg-gray-100" href="#">
      Hasil Diagnosa
     </a>
     <span class="text-gray-300 font-normal mt-4 mb-1">
      Pengaturan
     </span>
     <a class="block py-2 px-3 rounded hover:bg-gray-100" href="#">
      Admin
     </a>
     <a class="block py-2 px-3 rounded hover:bg-gray-100" href="#">
      Logout
     </a>
    </nav>
   </aside>
   <!-- Main content -->
   <main class="flex-1 flex flex-col">
    <!-- Top bar -->
    <header class="flex items-center justify-between border-b border-gray-200 px-4 py-2">
     <div class="flex items-center space-x-4">
      <button aria-label="Menu" class="text-[#1e2a4a] text-2xl focus:outline-none">
       <i class="fas fa-bars">
       </i>
      </button>
      <form class="relative">
       <input class="pl-4 pr-10 py-1 rounded text-sm font-semibold text-[#1e2a4a] placeholder-[#7a7a7a] bg-[#f0f4f4] border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" placeholder="Search" type="text"/>
       <button class="absolute right-2 top-1/2 -translate-y-1/2 text-[#1e2a4a]" type="submit">
        <i class="fas fa-search">
        </i>
       </button>
      </form>
     </div>
     <div class="flex items-center space-x-4">
      <button class="relative text-[#1e2a4a] text-xl focus:outline-none">
       <i class="fas fa-bell">
       </i>
       <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-semibold">
        1
       </span>
      </button>
      <button class="text-[#1e2a4a] text-xl focus:outline-none">
       <i class="fas fa-comment">
       </i>
      </button>
      <div class="flex items-center space-x-2">
       <img alt="Profile picture of a cat face" class="w-8 h-8 rounded-full object-cover" height="32" src="https://storage.googleapis.com/a1aa/image/c00e7c5e-5d4d-4b24-7738-15bfbed87736.jpg" width="32"/>
       <span class="text-sm font-semibold lowercase">
        aya
       </span>
      </div>
     </div>
    </header>
    <!-- Content -->
    <section class="p-6 space-y-6 overflow-auto">
     <div>
      <h1 class="text-2xl font-bold text-[#1e2a4a]">
       Dashboard
      </h1>
      <div class="text-xs text-gray-400 mt-1">
       Home
       <span class="text-gray-600 font-semibold">
        / Dashboard
       </span>
      </div>
     </div>
     <div class="flex flex-wrap gap-4">
      <div class="bg-white rounded p-4 w-full sm:w-60 text-xs text-[#1e2a4a] font-semibold">
       <div class="flex justify-between mb-2">
        <span>
         Daftar
        </span>
        <span class="font-normal text-gray-400">
         Gejala
        </span>
        <i class="fas fa-ellipsis-h text-gray-400">
        </i>
       </div>
       <div class="h-16">
       </div>
      </div>
      <div class="bg-white rounded p-4 w-full sm:w-60 text-xs text-[#1e2a4a] font-semibold">
       <div class="flex justify-between mb-2">
        <span>
         Gangguan
        </span>
        <span class="font-normal text-gray-400">
         Depresi
        </span>
        <i class="fas fa-ellipsis-h text-gray-400">
        </i>
       </div>
       <div class="h-16">
       </div>
      </div>
      <div class="bg-white rounded p-4 w-full sm:w-60 text-xs text-[#1e2a4a] font-semibold">
       <div class="flex justify-between mb-2">
        <span>
         Jumlah
        </span>
        <span class="font-normal text-gray-400">
         Admin
        </span>
        <i class="fas fa-ellipsis-h text-gray-400">
        </i>
       </div>
       <div class="h-16">
       </div>
      </div>
     </div>
     <div class="bg-white rounded p-4 text-xs text-[#1e2a4a] font-semibold overflow-x-auto">
      <div class="flex justify-between mb-2">
       <span>
        Daftar
       </span>
       <span class="font-normal text-gray-400">
        Gejala
       </span>
       <i class="fas fa-ellipsis-h text-gray-400">
       </i>
      </div>
      <table class="w-full border-collapse">
       <thead class="bg-[#f9fbfc] text-[#1e2a4a]">
        <tr>
         <th class="text-left py-2 px-3 border-b border-gray-200 w-12 font-semibold">
          #
         </th>
         <th class="text-left py-2 px-3 border-b border-gray-200 font-semibold">
          Kode Kendala
         </th>
         <th class="text-left py-2 px-3 border-b border-gray-200 font-semibold">
          Gejala
         </th>
        </tr>
       </thead>
       <tbody class="text-sm font-normal">
        <tr>
         <td class="py-2 px-3 border-b border-gray-200 font-semibold text-[#1e2a4a]">
          #1
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a] font-semibold">
          G001
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a]">
          Sering Merasa Sedih
         </td>
        </tr>
        <tr>
         <td class="py-2 px-3 border-b border-gray-200 font-semibold text-[#1e2a4a]">
          #2
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a] font-semibold">
          G002
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a]">
          Sering kelelahan melakukan aktifitas ringan
         </td>
        </tr>
        <tr>
         <td class="py-2 px-3 border-b border-gray-200 font-semibold text-[#1e2a4a]">
          #3
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a] font-semibold">
          G003
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a]">
          Kurang konsentrasi dalam belajar
         </td>
        </tr>
        <tr>
         <td class="py-2 px-3 border-b border-gray-200 font-semibold text-[#1e2a4a]">
          #4
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a] font-semibold">
          G004
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a]">
          Mudah Merasa bosan
         </td>
        </tr>
        <tr>
         <td class="py-2 px-3 border-b border-gray-200 font-semibold text-[#1e2a4a]">
          #5
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a] font-semibold">
          G005
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a]">
          Sering Melamun
         </td>
        </tr>
        <tr>
         <td class="py-2 px-3 border-b border-gray-200 font-semibold text-[#1e2a4a]">
          #6
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a] font-semibold">
          G006
         </td>
         <td class="py-2 px-3 border-b border-gray-200 text-[#1e2a4a]">
          Tidak semangat melakukan sesuatu
         </td>
        </tr>
       </tbody>
      </table>
     </div>
    </section>
   </main>
  </div>
 </body>
</html>
