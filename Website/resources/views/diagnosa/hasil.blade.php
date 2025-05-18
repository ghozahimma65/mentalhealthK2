<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa Tingkat Depresi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Menggunakan font Inter seperti contoh sebelumnya */
        }
        /* Custom styles untuk stepper agar lebih mirip */
        .stepper-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .stepper-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 12px; /* Sesuaikan dengan ukuran lingkaran */
            left: 50%;
            width: 100%; /* Lebar garis disesuaikan oleh parent */
            height: 2px;
            background-color: #e0e0e0; /* Warna garis default */
            transform: translateX(50%);
            z-index: -1;
        }
        .stepper-item.active .stepper-circle {
            background-color: #80CBC4; /* Warna Teal Muda untuk aktif */
            border-color: #80CBC4;
        }
        .stepper-item.completed .stepper-circle {
            background-color: #2C3E50; /* Warna Biru Tua untuk completed */
            border-color: #2C3E50;
        }
        .stepper-item.completed .stepper-icon {
            color: white;
        }
        .stepper-item.completed + .stepper-item::after, /* Garis setelah item completed */
        .stepper-item.active + .stepper-item::after { /* Garis setelah item active (jika ada item berikutnya) */
             /* Tidak perlu diubah jika sudah diatur oleh parent, tapi bisa di-override */
        }
        .stepper-item.completed:not(:last-child)::after {
            background-color: #2C3E50; /* Warna garis setelah item completed */
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
            z-index: 1;
        }
        .stepper-label {
            font-size: 0.875rem; /* 14px */
            color: #757575; /* Warna abu-abu untuk label */
        }
        .stepper-item.active .stepper-label,
        .stepper-item.completed .stepper-label {
            color: #2C3E50; /* Warna biru tua untuk label aktif/completed */
            font-weight: 600;
        }
        .table-custom th, .table-custom td {
            padding: 0.75rem; /* 12px */
            text-align: left;
            border-bottom-width: 1px;
            border-color: #e2e8f0; /* slate-200 */
        }
        .table-custom th {
            background-color: #f8fafc; /* slate-50 */
            font-weight: 600;
            color: #334155; /* slate-700 */
        }
        .table-custom tbody tr:nth-child(odd) {
           /* Latar belakang belang jika diinginkan */
           /* background-color: #f9fafb; */ /* gray-50 */
        }
        .table-pakar td:nth-child(3), .table-user td:nth-child(2), .table-hasil td:nth-child(1) {
            text-align: center;
        }
        .table-pakar th:nth-child(3), .table-user th:nth-child(2), .table-hasil th:nth-child(1) {
            text-align: center;
        }
    </style>
</head>
<body class="bg-[#E0F2F1] min-h-screen text-[#2C3E50]"> {{-- Latar belakang Teal sangat muda --}}

    {{-- Navbar --}}
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <div class="bg-[#80CBC4] p-2 rounded-full mr-3"> {{-- Lingkaran Teal Muda untuk ikon --}}
                    <i class="fas fa-sad-tear fa-lg text-white"></i> {{-- Ikon wajah sedih --}}
                </div>
                <a class="text-xl font-semibold text-[#2C3E50]" href="#">Diagnosa Tingkat Depresi</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-[#2C3E50] hover:text-[#1A2433]">Home</a>
                <a href="#" class="text-[#2C3E50] hover:text-[#1A2433]">About</a>
                <button class="bg-[#80CBC4] text-white px-4 py-2 rounded-full hover:bg-[#4DB6AC] text-sm font-medium">
                    cek tingkat depresi kamu
                </button>
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-[#2C3E50] mb-8">Hasil</h1>

        {{-- Stepper/Progress Bar --}}
        <div class="w-full max-w-2xl mx-auto mb-12">
            <div class="grid grid-cols-3 gap-x-2 items-start"> {{-- Menggunakan grid untuk stepper --}}
                <div class="stepper-item completed">
                    <div class="stepper-circle">
                        <i class="fas fa-check stepper-icon"></i>
                    </div>
                    <div class="stepper-label">Informasi Tes</div>
                </div>
                <div class="stepper-item completed">
                    <div class="stepper-circle">
                         <i class="fas fa-check stepper-icon"></i>
                    </div>
                    <div class="stepper-label">Pertanyaan Tes</div>
                </div>
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
                        <th class="w-1/12">#</th>
                        <th class="w-3/12">Diagnosa ID</th>
                        <th class="w-5/12">Tingkat Depresi</th>
                        <th class="w-3/12 text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1</td>
                        <td>9876543</td>
                        <td>P001 | Gangguan Mood</td>
                        <td class="text-center font-semibold">100 %</td>
                    </tr>
                    {{-- Tambahkan baris lain jika ada lebih dari satu hasil --}}
                </tbody>
            </table>
        </div>

        {{-- Tiga Tabel Perbandingan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Tabel Pakar --}}
            <div class="bg-white shadow-lg rounded-lg overflow-hidden table-custom table-pakar">
                <h2 class="text-lg font-semibold p-4 bg-gray-50 border-b text-center">Pakar</h2>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gejala</th>
                            <th>Nilai (MB-MD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>G001 | P001</td><td>0.4</td></tr>
                        <tr><td>2</td><td>G002 | P001</td><td>0.2</td></tr>
                        <tr><td>3</td><td>G003 | P001</td><td>1</td></tr>
                        <tr><td>4</td><td>G004 | P001</td><td>0.2</td></tr>
                        <tr><td>5</td><td>G005 | P001</td><td>0.6</td></tr>
                        <tr><td>6</td><td>G007 | P001</td><td>0.2</td></tr>
                        {{-- Tambahkan baris data pakar lainnya --}}
                    </tbody>
                </table>
            </div>

            {{-- Tabel User --}}
            <div class="bg-white shadow-lg rounded-lg overflow-hidden table-custom table-user">
                 <h2 class="text-lg font-semibold p-4 bg-gray-50 border-b text-center">User</h2>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr>
                            <th>Gejala</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>G001</td><td>0</td></tr>
                        <tr><td>G002</td><td>0</td></tr>
                        <tr><td>G003</td><td>0</td></tr>
                        <tr><td>G004</td><td>0</td></tr>
                        <tr><td>G005</td><td>0</td></tr>
                        <tr><td>G007</td><td>0</td></tr>
                        {{-- Tambahkan baris data user lainnya --}}
                    </tbody>
                </table>
            </div>

            {{-- Tabel Hasil --}}
            <div class="bg-white shadow-lg rounded-lg overflow-hidden table-custom table-hasil">
                <h2 class="text-lg font-semibold p-4 bg-gray-50 border-b text-center">Hasil</h2>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>0</td></tr>
                        <tr><td>0</td></tr>
                        <tr><td>0</td></tr>
                        <tr><td>0</td></tr>
                        <tr><td>0</td></tr>
                        <tr><td>0</td></tr>
                        {{-- Tambahkan baris data hasil lainnya --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Footer jika diperlukan --}}
    {{-- <footer class="text-center py-4 text-sm text-gray-600">
        &copy; 2024 Diagnosa Tingkat Depresi. All rights reserved.
    </footer> --}}

</body>
</html>
