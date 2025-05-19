@extends('layouts.app')

@section('title', $kode . ' | ' . $nama_gangguan . ' - Informasi Gangguan')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <div class="mb-6 pb-4 border-b border-gray-200">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#023047]">
                {{ $kode }} | {{ $nama_gangguan }}
            </h1>
            <p class="mt-2 text-sm md:text-base text-gray-600 italic">
                {{ $kesimpulan }}
            </p>
        </div>

        <div class="text-gray-700">
            <h2 class="text-xl md:text-2xl font-semibold text-[#023047] mb-4 text-center">
                {{ $nama_gangguan }}
            </h2>

            @if(isset($path_gambar) && file_exists(public_path($path_gambar)))
                <img src="{{ asset($path_gambar) }}" alt="Ilustrasi {{ $nama_gangguan }}" class="w-full max-w-md mx-auto h-auto rounded-lg shadow mb-6 border border-gray-200" />
            @else
                <div class="text-center text-red-500 my-4">
                    <i class="fas fa-image mr-2"></i>Gambar ilustrasi tidak ditemukan.
                </div>
            @endif

            <div class="prose max-w-none">
                <p class="mb-4 text-base leading-relaxed">
                    {{ $deskripsi_gangguan }}
                </p>

                @if(!empty($poin_deskripsi))
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach($poin_deskripsi as $poin)
                            <li class="text-base leading-relaxed">
                                @if(is_string($poin) && str_contains($poin, ':'))
                                    <strong>{{ Illuminate\Support\Str::before($poin, ':') }}:</strong> {{ Illuminate\Support\Str::after($poin, ':') }}
                                @else
                                    {{ $poin }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
