@extends('admin.dashboard')

@section('title', 'Riwayat Outcome')
@section('header_title', 'Riwayat Outcome Pengguna')

@section('content')
    <div class="container mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Riwayat Outcome Pengguna</h1>

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

        {{-- PERBAIKAN: Menggunakan $riwayatOutcomes sesuai dengan yang dikirim dari controller --}}
        @if ($riwayatOutcomes->isEmpty())
            <p class="text-gray-600 text-center">Tidak ada riwayat outcome yang tersedia.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PENGGUNA</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">HASIL OUTCOME</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">TANGGAL & WAKTU OUTCOME</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PROSES ADMIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- PERBAIKAN: Menggunakan $riwayatOutcomes sebagai variabel loop --}}
                        @foreach ($riwayatOutcomes as $outcome)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $outcome->predicted_outcome ?? 'Belum Diprediksi' }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i') : '-' }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @if ($outcome->admin_processed)
                                        <span class="text-green-600">Sudah</span>
                                    @else
                                        <span class="text-red-600">Belum</span>
                                    @endif
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
    </style>
@endpush
