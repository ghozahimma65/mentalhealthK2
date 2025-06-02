@extends('admin.dashboard')

@section('title', 'Riwayat Outcome')
@section('header_title', 'Riwayat Outcome Pengguna')

@section('content')
    <div class="container p-6 mx-auto bg-white rounded shadow-md">
        <h1 class="mb-4 text-2xl font-bold">Riwayat Outcome Pengguna</h1>

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
            <p class="text-center text-gray-600">Tidak ada riwayat outcome yang tersedia.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">PENGGUNA</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">HASIL OUTCOME</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">TANGGAL & WAKTU OUTCOME</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">PROSES ADMIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- PERBAIKAN: Menggunakan $riwayatOutcomes sebagai variabel loop --}}
                        @foreach ($riwayatOutcomes as $outcome)
                            <tr>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $outcome->predicted_outcome ?? 'Belum Diklasifikasi' }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i') : '-' }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">
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
