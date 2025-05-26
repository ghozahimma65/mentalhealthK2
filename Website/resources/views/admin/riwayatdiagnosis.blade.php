@extends('admin.dashboard') {{-- Pastikan ini meng-extend layout yang benar --}}

@section('title', 'Riwayat Diagnosis')
@section('header_title', 'Riwayat Diagnosis')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Riwayat Diagnosis Pengguna</h1>

        @if ($riwayatDiagnoses->isEmpty())
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">Belum ada riwayat diagnosis yang tersimpan. Lakukan prediksi terlebih dahulu.</span>
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
                                Hasil Diagnosis
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal & Waktu Diagnosis
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($riwayatDiagnoses as $diagnosis)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $diagnosis->user->name ?? 'Pengguna Tidak Dikenal' }}
                                    @if ($diagnosis->user_id)
                                        {{-- Opsional: Tampilkan ID pengguna jika ingin --}}
                                        {{-- <span class="text-gray-500 text-xs">({{ $diagnosis->user_id }})</span> --}}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
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
                                    <span class="font-bold text-lg">
                                        {{ $diagnosisText }} {{-- Hanya tampilkan teks deskripsi --}}
                                    </span>
                                    {{-- Jika Anda ingin menampilkan angka aslinya juga, bisa tambahkan di sini: --}}
                                    {{-- <br>
                                    <span class="text-sm text-gray-600">({{ $diagnosis->predicted_diagnosis }})</span> --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
