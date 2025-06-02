@extends('admin.dashboard')

@section('title', 'Riwayat Outcome')
@section('header_title', 'Riwayat Outcome Pengguna')

@section('content')
    <div class="container p-6 mx-auto bg-white rounded shadow-md">
        <h1 class="mb-4 text-2xl font-bold">Riwayat Outcome Pengguna</h1>
    <div class="container py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Riwayat Outcome Pengguna</h1>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($riwayatOutcomes->isEmpty())
            <p class="text-center text-gray-600">Tidak ada riwayat outcome yang tersedia.</p>
            <div class="relative px-4 py-3 text-blue-700 bg-blue-100 border border-blue-400 rounded" role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">Belum ada riwayat outcome yang tersimpan. Lakukan prediksi terlebih dahulu.</span>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">PENGGUNA</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">HASIL OUTCOME</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">TANGGAL & WAKTU OUTCOME</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">PROSES ADMIN</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Pengguna
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Hasil Outcome
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tanggal & Waktu Outcome
                            </th>
                            {{-- Kolom "PROSES ADMIN" telah dihapus dari thead --}}
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
                                    <span class="text-lg font-bold">
                                        {{ $outcomeText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i:s') : '-' }}
                                </td>
                                {{-- Data "PROSES ADMIN" telah dihapus dari tbody --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .container {
            width: 95%;
            margin: 0 auto;
            padding: 3rem;
            border-radius: 0.75rem;
        }
        .min-w-full {
            min-width: 100%;
        }
        .divide-y > * + * {
            border-top-width: 1px;
        }
    </style>
@endpush