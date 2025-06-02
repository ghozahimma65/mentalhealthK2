@extends('admin.dashboard')

@section('title', 'Prediksi Outcome Tertunda') {{-- Judul disesuaikan --}}
@section('header_title', 'Prediksi Outcome Tertunda') {{-- Judul disesuaikan --}}

@section('content')
    <div class="container mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Detail Pengguna & Inputan Outcome Tertunda</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($outcomeResults->isEmpty())
            <p class="text-gray-600 text-center py-10">Tidak ada data outcome yang menunggu untuk diprediksi.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">USER</th>
                            <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">WAKTU PENGAJUAN</th>
                            <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">INPUTAN (OUTCOME)</th>
                            <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($outcomeResults as $outcome)
                            <tr>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i') : '-' }}</td>
                                <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                    {{-- Memanggil metode helper dari model $outcome --}}
                                    {{-- Metode helper ini akan mengakses $outcome->input_data secara internal --}}
                                    {{-- Pastikan nama kunci di input_data cocok dengan yang diakses metode helper model --}}
                                    <ul class="list-disc pl-5">
                                        <li><strong>Diagnosis Awal:</strong> {{ $outcome->getDiagnosisDescriptionFromInput() }}</li>
                                        <li><strong>Tingkat Keparahan Gejala:</strong> {{ $outcome->getSymptomSeverityDescriptionFromInput() }}</li>
                                        <li><strong>Skor Suasana Hati:</strong> {{ $outcome->getMoodScoreDescriptionFromInput() }}</li>
                                        <li><strong>Aktivitas Fisik:</strong> {{ $outcome->getPhysicalActivityDescriptionFromInput() }}</li>
                                        <li><strong>Pengobatan:</strong> {{ $outcome->getMedicationDescriptionFromInput() }}</li>
                                        <li><strong>Jenis Terapi:</strong> {{ $outcome->getTherapyTypeDescriptionFromInput() }}</li>
                                        <li><strong>Durasi Pengobatan:</strong> {{ $outcome->getTreatmentDurationDescriptionFromInput() }}</li>
                                        <li><strong>Tingkat Stres:</strong> {{ $outcome->getStressLevelDescriptionFromInput() }}</li>
                                        {{-- Jika ada field lain di input_data yang ingin ditampilkan deskripsinya, buatkan metode helper di model --}}
                                    </ul>
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200 text-center">
                                    <form action="{{ route('admin.outcome.prediksi', $outcome->id) }}" method="POST"> {{-- Pastikan nama rute 'admin.outcome.prediksi' benar --}}
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">
                                            Prediksi
                                        </button>
                                    </form>
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
    {{-- Anda bisa menggunakan kelas Tailwind langsung atau CSS kustom jika diperlukan --}}
    <style>
        /* .alert-success, .alert-error bisa diganti dengan kelas Tailwind */
    </style>
@endpush