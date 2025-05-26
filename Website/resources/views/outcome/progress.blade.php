@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Riwayat Perkembangan Pengobatan Saya') {{-- Judul halaman --}}

@section('content') {{-- Konten utama halaman --}}
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Riwayat Perkembangan Pengobatan Anda</h1>
        <p class="mb-8 text-gray-600">Berikut adalah catatan perkembangan pengobatan Anda. Pantau terus progres Anda.</p>

        @if ($outcomes->isEmpty())
            <div class="p-4 text-blue-700 bg-blue-100 border-l-4 border-blue-500" role="alert">
                <p class="font-bold">Belum Ada Data Perkembangan!</p>
                <p>Anda belum mencatat perkembangan pengobatan apa pun. <a href="{{ route('outcome.create') }}" class="underline">Mulai catat yang pertama sekarang</a>.</p>
            </div>
        @else
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Diagnosis
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tingkat Gejala
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Suasana Hati
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Hasil Prediksi
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Detail</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($outcomes as $outcome)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($outcome->timestamp)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($outcome->timestamp)->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $this->mapDiagnosisCodeToName($outcome->diagnosis) }}</div> {{-- Perlu helper di Controller --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $outcome->symptom_severity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $outcome->mood_score }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-blue-600">{{ $outcome->predicted_outcome }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="{{ route('outcome.show', $outcome->_id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-4">
                {{ $outcomes->links() }}
            </div>
        @endif
    </div>
@endsection