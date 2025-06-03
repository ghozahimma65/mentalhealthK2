@extends('admin.dashboard')

@section('title', 'Klasifikasi Outcome Tertunda') {{-- Judul disesuaikan --}}
@section('header_title', 'Klasifikasi Outcome Tertunda') {{-- Judul disesuaikan --}}

@section('content')
    <div class="container p-6 mx-auto bg-white rounded shadow-md">
        <h1 class="mb-4 text-2xl font-bold">Detail Pengguna & Inputan Outcome</h1>
    <div class="container p-6 mx-auto bg-white rounded shadow-md">
        <h1 class="mb-4 text-2xl font-bold">Detail Pengguna & Inputan Outcome Tertunda</h1>

        @if (session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($outcomeResults->isEmpty())
            <p class="py-10 text-center text-gray-600">Tidak ada data outcome yang menunggu untuk diklasifikasi.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">USER</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">WAKTU PENGAJUAN</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">INPUTAN (OUTCOME)</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">AKSI</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">USER</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">WAKTU PENGAJUAN</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">INPUTAN (OUTCOME)</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase bg-gray-100 border-b border-gray-200">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($outcomeResults as $outcome)
                            <tr>
                                <td class="px-4 py-3 border-b border-gray-200">{{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}</td>
                                <td class="px-4 py-3 border-b border-gray-200">{{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i') : '-' }}</td>
                                <td class="px-4 py-3 text-sm border-b border-gray-200">
                                    {{-- Memanggil metode helper dari model $outcome --}}
                                    {{-- Metode helper ini akan mengakses $outcome->input_data secara internal --}}
                                    {{-- Pastikan nama kunci di input_data cocok dengan yang diakses metode helper model --}}
                                    <ul class="pl-5 list-disc">
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
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <form action="{{ route('admin.outcome.prediksi', $outcome->id) }}" method="POST">
                                <td class="px-4 py-3 text-center border-b border-gray-200">
                                    <form action="{{ route('admin.outcome.prediksi', $outcome->id) }}" method="POST"> {{-- Pastikan nama rute 'admin.outcome.prediksi' benar --}}
                                        @csrf
                                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                            Klasifikasi
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