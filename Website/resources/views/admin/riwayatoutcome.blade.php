@extends('admin.dashboard')

@section('title', 'Riwayat Outcome')
@section('header_title', 'Riwayat Outcome Pengguna')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Riwayat Outcome Pengguna</h1>

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
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">Belum ada riwayat outcome yang tersimpan. Lakukan prediksi terlebih dahulu.</span>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pengguna
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hasil Outcome
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal & Waktu Outcome
                            </th>
                            {{-- Kolom "PROSES ADMIN" telah dihapus dari thead --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($riwayatOutcomes as $outcome)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}
                                    @if ($outcome->user_id)
                                        {{-- Opsional: Tampilkan ID pengguna jika ingin --}}
                                        {{-- <span class="text-gray-500 text-xs">({{ $outcome->user_id }})</span> --}}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    @php
                                        $outcomeText = 'Outcome Tidak Dikenal';
                                        switch ((int)$outcome->predicted_outcome) {
                                            case 0: $outcomeText = 'Deteriorated(memburuk)'; break;
                                            case 1: $outcomeText = 'Improved(membaik)'; break;
                                            case 2: $outcomeText = 'No Change(tidak ada perubahan)'; break;
                                            default: $outcomeText = 'Outcome tidak diketahui'; break;
                                        }
                                    @endphp
                                    <span class="font-bold text-lg">
                                        {{ $outcomeText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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