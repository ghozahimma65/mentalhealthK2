<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Diagnosa Register Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#f0f7fc] min-h-screen flex items-start justify-start p-6 relative overflow-x-hidden">
    <div class="absolute left-0 bottom-0 w-[600px] max-w-full select-none pointer-events-none -z-10">
        <img
            alt="Illustration of a large pink brain with four medical staff around it"
            class="w-full h-auto"
            src="{{ asset('assets/ilustrasions.png') }}"
        />
    </div>

    <div class="z-10 flex items-center mt-6 ml-6 space-x-4">
        <div class="w-20 h-20 rounded-xl bg-[#4a86c5] flex items-center justify-center shadow-md">
            <img alt="Diagnosa Logo" class="w-12 h-12" height="48" src="{{ asset('assets/logo.png') }}" width="48"/>
        </div>
        <span class="text-[#4a86c5] text-lg font-semibold select-none drop-shadow-md" style="text-shadow: 0 2px 2px rgba(0,0,0,0.3)">
            Diagnosa
        </span>
    </div>

    <div class="z-10 flex items-center justify-end flex-1 px-4 mt-12">
        <div class="relative bg-[#d9f0f3] rounded-2xl p-8 max-w-md w-full shadow-lg mr-10 md:mr-20" style="backdrop-filter: saturate(180%) blur(20px)">
            <div class="flex flex-col items-center mb-6">
                <div class="w-10 h-10 rounded-md bg-[#4a86c5] flex items-center justify-center mb-2">
                    <img alt="Diagnosa Logo Small" class="w-6 h-6" height="24" src="{{ asset('assets/logo.png') }}" width="24"/>
                </div>
                <h1 class="text-[#1a2a5a] font-semibold text-xl select-none">
                    Admin Register
                </h1>
            </div>

            {{-- Menampilkan error validasi umum --}}
            @if ($errors->any())
                <div class="p-3 mb-4 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf {{-- Token CSRF untuk keamanan --}}

                <div>
                    <label class="block text-[#1a2a5a] font-semibold text-xs mb-1 select-none" for="name">
                        Name
                    </label>
                    <input class="w-full rounded-full px-4 py-2 text-xs border focus:border-[#4a86c5] focus:ring focus:ring-[#4a86c5]/50 focus:outline-none @error('name') border-red-500 @enderror"
                           id="name"
                           style="background-color: #ffffff"
                           type="text"
                           name="name" {{-- Nama input untuk backend --}}
                           value="{{ old('name') }}" {{-- Untuk mempertahankan input jika ada error --}}
                           required
                           autofocus />
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[#1a2a5a] font-semibold text-xs mb-1 select-none" for="email">
                        Email
                    </label>
                    <input class="w-full rounded-full px-4 py-2 text-xs border focus:border-[#4a86c5] focus:ring focus:ring-[#4a86c5]/50 focus:outline-none @error('email') border-red-500 @enderror"
                           id="email"
                           style="background-color: #ffffff"
                           type="email"
                           name="email" {{-- Nama input untuk backend --}}
                           value="{{ old('email') }}" {{-- Untuk mempertahankan input jika ada error --}}
                           required />
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[#1a2a5a] font-semibold text-xs mb-1 select-none" for="password">
                        Password
                    </label>
                    <input class="w-full rounded-full px-4 py-2 text-xs border focus:border-[#4a86c5] focus:ring focus:ring-[#4a86c5]/50 focus:outline-none @error('password') border-red-500 @enderror"
                           id="password"
                           style="background-color: #ffffff"
                           type="password"
                           name="password" {{-- Nama input untuk backend --}}
                           required />
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[#1a2a5a] font-semibold text-xs mb-1 select-none" for="password_confirmation">
                        Confirm Password
                    </label>
                    <input class="w-full rounded-full px-4 py-2 text-xs border focus:border-[#4a86c5] focus:ring focus:ring-[#4a86c5]/50 focus:outline-none"
                           id="password_confirmation"
                           style="background-color: #ffffff"
                           type="password"
                           name="password_confirmation" {{-- Nama input untuk backend --}}
                           required />
                </div>

                <button class="w-full bg-[#4a86c5] text-white font-semibold text-sm rounded-full py-2 mt-4 hover:bg-[#3a6db3] transition-colors" type="submit">
                    Register
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-[#1a2a5a] text-xs select-none">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-[#4a86c5] hover:underline focus:outline-none">Login here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>