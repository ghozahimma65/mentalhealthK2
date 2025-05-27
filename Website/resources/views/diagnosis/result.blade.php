<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosis Kesehatan Mental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        /* Make images responsive */
        .diagnosis-image {
            max-width: 100%;
            height: auto;
            margin-top: 1.5rem; /* Add some space above the image */
            border-radius: 0.5rem; /* Rounded corners for images */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md p-8 text-center bg-white border border-gray-200 rounded-lg shadow-xl">
        <h1 class="mb-4 text-3xl font-bold text-gray-800">Hasil Diagnosis Anda</h1>
        <p class="mb-6 text-gray-600">Berdasarkan data yang Anda berikan, diagnosis awal adalah:</p>

        @if (isset($diagnosis))
            <div class="px-6 py-4 mb-8 text-blue-800 border border-blue-200 rounded-lg bg-blue-50">
                <p class="text-4xl font-extrabold">{{ $diagnosis }}</p>
                <p class="mt-2 text-sm">
                    @if ($diagnosis == 0)
                        (Gangguan Bipolar)
                    @elseif ($diagnosis == 1)
                        (Gangguan Kecemasan Umum)
                    @elseif ($diagnosis == 2)
                        (Gangguan Depresi Mayor)
                    @elseif ($diagnosis == 3)
                        (Gangguan Panik)
                    @else
                        (Diagnosis tidak diketahui atau perlu pemeriksaan lebih lanjut)
                    @endif
                </p>
                {{-- Gambar yang menggambarkan diagnosis --}}
                @if ($diagnosis == 0)
                    <img src="https://placehold.co/300x200/A0B9D9/ffffff?text=Bipolar+Disorder" alt="Gambar Gangguan Bipolar" class="mx-auto diagnosis-image">
                @elseif ($diagnosis == 1)
                    <img src="https://placehold.co/300x200/D9A0B9/ffffff?text=Generalized+Anxiety" alt="Gambar Gangguan Kecemasan Umum" class="mx-auto diagnosis-image">
                @elseif ($diagnosis == 2)
                    <img src="https://placehold.co/300x200/B9D9A0/ffffff?text=Major+Depressive+Disorder" alt="Gambar Gangguan Depresi Mayor" class="mx-auto diagnosis-image">
                @elseif ($diagnosis == 3)
                    <img src="https://placehold.co/300x200/D9B9A0/ffffff?text=Panic+Disorder" alt="Gambar Gangguan Panik" class="mx-auto diagnosis-image">
                @else
                    <img src="https://placehold.co/300x200/CCCCCC/ffffff?text=Diagnosis+Tidak+Diketahui" alt="Gambar Diagnosis Tidak Diketahui" class="mx-auto diagnosis-image">
                @endif
            </div>
            <p class="text-sm text-gray-700">
                *Diagnosis ini adalah hasil prediksi awal dan tidak menggantikan konsultasi profesional.
                Jika Anda merasa membutuhkan bantuan, silakan hubungi ahli kesehatan mental.
            </p>
        @else
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong class="font-bold">Maaf!</strong>
                <span class="block sm:inline">Tidak dapat menampilkan hasil diagnosis.</span>
            </div>
        @endif

        <a href="{{ route('diagnosis.form') }}"
           class="inline-flex items-center px-6 py-3 mt-8 text-base font-medium text-white transition duration-200 ease-in-out bg-gray-600 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Kembali ke Kuesioner
        </a>
    </div>
</body>
</html>
