@extends('admin.dashboard') {{-- Pastikan ini meng-extend layout yang benar --}}

@section('title', 'Riwayat Diagnosis')
@section('header_title', 'Riwayat Diagnosis')

@section('content')
    <div class="container py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Riwayat Diagnosis Pengguna</h1>

        @if ($riwayatDiagnoses->isEmpty())
            <div class="relative px-4 py-3 text-blue-700 bg-blue-100 border border-blue-400 rounded" role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">Belum ada riwayat diagnosis yang tersimpan. Lakukan Klasifikasi terlebih dahulu.</span>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Pengguna
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Hasil Diagnosis
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tanggal & Waktu Diagnosis
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($riwayatDiagnoses as $diagnosis)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ $diagnosis->user->name ?? 'Pengguna Tidak Dikenal' }}
                                    @if ($diagnosis->user_id)
                                        {{-- Opsional: Tampilkan ID pengguna jika ingin --}}
                                        {{-- <span class="text-xs text-gray-500">({{ $diagnosis->user_id }})</span> --}}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                    @php
                                        $diagnosisText = 'Diagnosis Tidak Dikenal';
                                        // Sesuaikan mapping ini dengan output sebenarnya dari model Flask Anda
                                        switch ((int)$diagnosis->predicted_diagnosis) { // Pastikan di-cast ke integer
                                            case 0: $diagnosisText = 'Gangguan Bipolar'; break; // Sesuai result.blade.php
                                            case 1: $diagnosisText = 'Gangguan Kecemasan Umum (Anxiety)'; break; // Sesuai result.blade.php
                                            case 2: $diagnosisText = 'Gangguan Depresi Mayor'; break; // Sesuai result.blade.php
                                            case 3: $diagnosisText = 'Gangguan Panik (Panick Attack)'; break; // Sesuai result.blade.php
                                            default: $diagnosisText = 'Diagnosis tidak diketahui atau perlu pemeriksaan lebih lanjut'; break;
                                        }
                                    @endphp
                                    <span class="text-lg font-bold">
                                        {{ $diagnosisText }} {{-- Hanya tampilkan teks deskripsi --}}
                                    </span>
                                    {{-- Jika Anda ingin menampilkan angka aslinya juga, bisa tambahkan di sini: --}}
                                    {{-- <br>
                                    <span class="text-sm text-gray-600">({{ $diagnosis->predicted_diagnosis }})</span> --}}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $diagnosis->timestamp->format('d M Y, H:i:s') }}
                                </td>
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
        .container {
            width: 95%; /* Mengatur lebar container menjadi 95% dari lebar parent-nya */
            margin: 0 auto;
            /* background-color: white; (Ini akan dihandle oleh div tabel) */
            padding: 3rem; /* Memberikan padding yang cukup */
            border-radius: 0.75rem;
            /* box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); (Ini juga akan dihandle oleh div tabel) */
        }
        /* Tambahan styling untuk tabel jika diperlukan, atau andalkan Tailwind */
        .min-w-full {
            min-width: 100%;
        }
        .divide-y > * + * {
            border-top-width: 1px;
        }
    </style>
@endpush
