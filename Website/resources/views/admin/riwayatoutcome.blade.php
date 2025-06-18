@extends('admin.dashboard')

@section('title', 'Riwayat Outcome')
@section('header_title', 'Riwayat Outcome Pengguna')

@section('content')
    {{-- Menggunakan satu kontainer utama dan satu judul H1 --}}
    <div class="container p-6 mx-auto bg-white rounded shadow-md">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Riwayat Outcome Pengguna</h1>

        @if (session('success'))
            {{-- Menggunakan kelas Tailwind untuk alert sukses --}}
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            {{-- Menggunakan kelas Tailwind untuk alert error --}}
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($riwayatOutcomes->isEmpty())
            {{-- Pesan sederhana ketika tidak ada data --}}
            <p class="py-10 text-center text-gray-600">Tidak ada riwayat outcome yang tersedia.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- Menyesuaikan kolom header tabel --}}
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Pengguna
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Hasil Outcome
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tanggal & Waktu Outcome
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($riwayatOutcomes as $outcome)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}
                                    @if ($outcome->user_id)
                                        {{-- Opsional: Tampilkan ID pengguna jika ingin --}}
                                        {{-- <span class="text-xs text-gray-500">({{ $outcome->user_id }})</span> --}}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                    @php
                                        $outcomeText = 'Outcome Tidak Dikenal';
                                        switch ((int)$outcome->predicted_outcome) {
                                            case 0: $outcomeText = 'Deteriorated(memburuk)'; break;
                                            case 1: $outcomeText = 'Improved(membaik)'; break;
                                            case 2: $outcomeText = 'No Change(tidak ada perubahan)'; break;
                                            default: $outcomeText = 'Outcome tidak diketahui'; break;
                                        }
                                    @endphp
                                    {{-- Menghilangkan styling text-lg font-bold agar konsisten dengan riwayatdiagnosis --}}
                                    <span> 
                                        {{ $outcomeText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i:s') : '-' }}
                                </td>
                                {{-- Kolom "PROSES ADMIN" sudah dihilangkan dari tbody dan thead --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    {{-- CSS kustom di sini bisa dihapus jika tidak ada lagi yang digunakan --}}
    {{-- <style>
        .container { -- Jika ini mendefinisikan ulang container Tailwind, sebaiknya dihapus -- }
    </style> --}}
@endpush