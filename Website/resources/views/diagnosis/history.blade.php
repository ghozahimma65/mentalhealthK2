{{-- resources/views/diagnosis/history.blade.php --}}
@extends('layouts.main')

@section('title', 'Riwayat Diagnosis Awal Anda')

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Riwayat Diagnosis Awal Anda</h1>
        <p class="mb-8 text-gray-600">Berikut adalah daftar diagnosis awal yang pernah Anda lakukan.</p>

        @php
            $diagnosisResults = $diagnosisResults ?? collect();
        @endphp

        @if ($diagnosisResults->isEmpty())
            <div class="p-4 text-blue-700 bg-blue-100 border-l-4 border-blue-500 rounded-lg" role="alert">
                <p class="font-bold">Belum Ada Riwayat Diagnosis!</p>
                <p>Mulai <a href="{{ route('diagnosis.form') }}" class="underline">diagnosis pertama Anda sekarang</a>.</p>
            </div>
        @else
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Usia</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Hasil Diagnosis</th>
                            <th class="relative px-6 py-3">
                                <span class="sr-only">Detail</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($diagnosisResults as $diagnosis)
                            @php
                                $resultColorClass = 'text-gray-800';
                                switch($diagnosis->predicted_diagnosis) {
                                    case 0: $resultColorClass = 'text-purple-600'; break;
                                    case 1: $resultColorClass = 'text-orange-600'; break;
                                    case 2: $resultColorClass = 'text-red-600'; break;
                                    case 3: $resultColorClass = 'text-yellow-600'; break;
                                }
                            @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($diagnosis->timestamp)->format('d M Y') }}
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($diagnosis->timestamp)->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    {{ $diagnosis->input_data['Age'] ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    {{ ($diagnosis->input_data['Gender'] ?? null) == 0 ? 'Pria' : 'Wanita' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $resultColorClass }}">
                                    {{ $diagnosisNameMap[$diagnosis->predicted_diagnosis] ?? 'Tidak Diketahui' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="{{ route('predictions.show', $diagnosis->_id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $diagnosisResults->links() }}
            </div>
        @endif

        <div class="p-6 mt-10 text-center rounded-lg shadow-md bg-purple-50">
    <h3 class="mb-3 text-xl font-semibold text-purple-800">Ingin melihat riwayat perkembangan pengobatan?</h3>
    <a href="{{ route('outcome.comprehensive_history') }}" {{-- ROUTE DISESUAIKAN DI SINI --}}
       class="inline-flex items-center px-6 py-3 text-base font-medium text-white transition duration-200 ease-in-out bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
        <i class="mr-2 fas fa-chart-line"></i> Kunjungi Halaman Perkembangan
    </a>
</div>
    </div>
@endsection