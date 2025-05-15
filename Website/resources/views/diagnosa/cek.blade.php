{{-- Menggunakan master layout dari resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Mengatur judul halaman yang akan muncul di tab browser --}}
@section('title', 'Hasil Diagnosa Tingkat Depresi')

{{-- Konten utama untuk halaman "Hasil Diagnosa" --}}
@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Judul Halaman "Hasil" - Disesuaikan dengan warna pada stepper aktif --}}
        <h1 class="text-3xl font-bold text-[#80CBC4] mb-8">Hasil</h1>

        {{-- Stepper/Progress Bar --}}
        <div class="w-full max-w-2xl mx-auto mb-12">
            <div class="grid grid-cols-3 gap-x-1 items-start relative">
                {{-- Item Stepper 1: Informasi Tes (Completed) --}}
                <div class="stepper-item completed">
                    <div class="stepper-circle">
                        <i class="fas fa-check stepper-icon"></i>
                    </div>
                    <div class="stepper-label">Informasi Tes</div>
                </div>
                {{-- Item Stepper 2: Pertanyaan Tes (Completed) --}}
                <div class="stepper-item completed">
                    <div class="stepper-circle">
                        <i class="fas fa-check stepper-icon"></i>
                    </div>
                    <div class="stepper-label">Pertanyaan Tes</div>
                </div>
                {{-- Item Stepper 3: Hasil Anda (Active) --}}
                <div class="stepper-item active">
                    <div class="stepper-circle">
                        {{-- Tidak ada ikon untuk state active, hanya warna --}}
                    </div>
                    <div class="stepper-label">Hasil Anda</div>
                </div>
            </div>
        </div>

        {{-- Tabel Ringkasan Hasil --}}
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-10 table-custom">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="w-1/12 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="w-4/12 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa ID</th> {{-- Adjusted width slightly --}}
                        <th class="w-4/12 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Depresi</th> {{-- Adjusted width slightly --}}
                        <th class="w-3/12 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">#1</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $diagnosaId ?? '9876543' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $tingkatDepresi ?? 'P001 | Gangguan Mood' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-center font-semibold">{{ $persentase ?? '100 %' }}</td>
                    </tr>
                    {{-- Tambahkan baris lain jika ada lebih dari satu hasil menggunakan @foreach --}}
                    {{-- Contoh jika $hasilDiagnosa adalah array of objects/arrays:
                    @foreach($hasilDiagnosa as $index => $hasil)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">#{{ $index + 1 }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $hasil->diagnosaId ?? 'N/A' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $hasil->tingkatDepresi ?? 'N/A' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-center font-semibold">{{ $hasil->persentase ?? '0 %' }}</td>
                    </tr>
                    @endforeach
                    --}}
                </tbody>
            </table>
        </div>

        {{-- Tiga Tabel Perbandingan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Tabel Pakar --}}
            <div class="bg-white shadow-lg rounded-lg overflow-hidden table-custom table-pakar">
                <h2 class="text-lg font-semibold p-4 bg-gray-100 border-b text-center text-[#2C3E50]">Pakar</h2>
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gejala</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai (MB-MD)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            // Data ini seharusnya datang dari controller
                            // Variabel $dataPakar dari controller akan menggantikan ini
                            $dataPakar = $dataPakar ?? [
                                ['no' => 1, 'gejala' => 'G001 | P001', 'nilai' => 0.4],
                                ['no' => 2, 'gejala' => 'G002 | P001', 'nilai' => 0.2],
                                ['no' => 3, 'gejala' => 'G003 | P001', 'nilai' => 1.0],
                                ['no' => 4, 'gejala' => 'G004 | P001', 'nilai' => 0.2],
                                ['no' => 5, 'gejala' => 'G005 | P001', 'nilai' => 0.6],
                                ['no' => 6, 'gejala' => 'G007 | P001', 'nilai' => 0.2],
                            ];
                        @endphp
                        @forelse($dataPakar as $item)
                        <tr>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700">{{ $item['no'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700">{{ $item['gejala'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 text-center">{{ number_format((float)($item['nilai'] ?? 0), 1) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-3 py-2 text-center text-gray-500">Data pakar tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tabel User --}}
            <div class="bg-white shadow-lg rounded-lg overflow-hidden table-custom table-user">
                <h2 class="text-lg font-semibold p-4 bg-gray-100 border-b text-center text-[#2C3E50]">User</h2>
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gejala</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            // Data ini seharusnya datang dari controller
                            $dataUser = $dataUser ?? [
                                ['gejala' => 'G001', 'nilai' => 0],
                                ['gejala' => 'G002', 'nilai' => 0],
                                ['gejala' => 'G003', 'nilai' => 0],
                                ['gejala' => 'G004', 'nilai' => 0],
                                ['gejala' => 'G005', 'nilai' => 0],
                                ['gejala' => 'G007', 'nilai' => 0],
                            ];
                        @endphp
                        @forelse($dataUser as $item)
                        <tr class="{{ $loop->even ? 'bg-red-50' : '' }}"> {{-- Screenshot menunjukkan baris genap diwarnai --}}
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700">{{ $item['gejala'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 text-center">{{ $item['nilai'] ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-3 py-2 text-center text-gray-500">Data user tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tabel Hasil --}}
            <div class="bg-white shadow-lg rounded-lg overflow-hidden table-custom table-hasil">
                <h2 class="text-lg font-semibold p-4 bg-gray-100 border-b text-center text-[#2C3E50]">Hasil</h2>
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            // Data ini seharusnya datang dari controller
                            $dataKalkulasiHasil = $dataKalkulasiHasil ?? [
                                ['nilai' => 0], ['nilai' => 0], ['nilai' => 0],
                                ['nilai' => 0], ['nilai' => 0], ['nilai' => 0],
                            ];
                        @endphp
                        @forelse($dataKalkulasiHasil as $item)
                        <tr class="{{ $loop->even ? 'bg-sky-50' : '' }}"> {{-- Screenshot menunjukkan baris genap diwarnai --}}
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 text-center">{{ $item['nilai'] ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-3 py-2 text-center text-gray-500">Data hasil kalkulasi tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
{{-- Style untuk Stepper dan penyesuaian tabel --}}
<style>
    .stepper-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex-grow: 1;
    }
    /* Garis antar stepper */
    .stepper-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 12px; /* Setengah tinggi lingkaran */
        left: calc(50% + 12px); /* Mulai setelah lingkaran */
        /* Dinamis menghitung lebar garis, dikurangi lebar 2 lingkaran dan sedikit margin jika perlu */
        width: calc(100% - 24px);
        height: 2px;
        background-color: #e0e0e0; /* Warna garis default */
        z-index: 0;
    }

    .stepper-circle {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #e0e0e0; /* Warna border default */
        background-color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
        z-index: 1; /* Di atas garis */
        position: relative;
    }
    .stepper-label {
        font-size: 0.875rem; /* 14px */
        color: #757575; /* Warna abu-abu untuk label */
        text-align: center;
    }

    /* Status: Active */
    .stepper-item.active .stepper-circle {
        background-color: #80CBC4; /* Teal Muda untuk aktif (sesuai screenshot) */
        border-color: #80CBC4;
    }
    .stepper-item.active .stepper-label {
        color: #2C3E50; /* Warna biru tua untuk label aktif/completed */
        font-weight: 600;
    }

    /* Status: Completed */
    .stepper-item.completed .stepper-circle {
        background-color: #2C3E50; /* Warna Biru Tua untuk completed (sesuai screenshot) */
        border-color: #2C3E50;
    }
    .stepper-item.completed .stepper-icon {
        color: white; /* Ikon centang putih */
    }
    .stepper-item.completed .stepper-label {
        color: #2C3E50;
        font-weight: 600;
    }
    .stepper-item.completed:not(:last-child)::after {
        background-color: #2C3E50; /* Warna garis setelah item completed */
    }

    /* Penyesuaian Tabel agar lebih mirip gambar */
    .table-custom th, .table-custom td {
        padding: 0.6rem 0.75rem; /* Sedikit penyesuaian padding */
    }
    .table-custom thead th {
        background-color: #f3f4f6; /* gray-100, lebih cocok dengan screenshot */
        color: #374151; /* gray-700 */
        font-weight: 600;
    }

    .table-pakar td:nth-child(3), /* Kolom nilai di tabel pakar */
    .table-user td:nth-child(2),  /* Kolom nilai di tabel user */
    .table-hasil td:nth-child(1) { /* Kolom nilai di tabel hasil */
        text-align: center;
    }
    .table-pakar th:nth-child(3),
    .table-user th:nth-child(2),
    .table-hasil th:nth-child(1) {
        text-align: center;
    }
    /* Menghilangkan border bawah pada baris terakhir agar tidak double dengan border card */
    .table-custom tbody tr:last-child td {
        border-bottom-width: 0;
    }

    /* Agar garis stepper tidak melebihi batas grid */
    .grid.grid-cols-3.gap-x-1 {
        /* Jika masih ada masalah, bisa tambahkan padding pada container stepper atau atur width secara lebih spesifik */
    }
</style>
@endpush

@push('scripts')
{{-- Font Awesome jika belum ada di layout utama --}}
{{-- <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script> --}}
<script>
    // console.log('Halaman Hasil Diagnosa dimuat.');
    // Anda dapat menambahkan JavaScript di sini jika diperlukan
</script>
@endpush