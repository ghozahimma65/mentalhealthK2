<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Prediksi Admin</title>
    {{-- Anda bisa menambahkan CSS framework seperti Bootstrap atau Tailwind CSS di sini --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="text-white card-header bg-primary">
                <h1 class="mb-0 card-title">Hasil Prediksi Model</h1>
            </div>
            <div class="card-body">
                @if (empty($predictionResults))
                    <div class="alert alert-warning" role="alert">
                        Belum ada data hasil prediksi.
                    </div>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Model</th>
                                <th scope="col">Akurasi</th>
                                {{-- Tambahkan kolom lain sesuai kebutuhan --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($predictionResults as $result)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $result['model'] }}</td>
                                    <td>{{ number_format($result['akurasi'] * 100, 2) }}%</td>
                                    {{-- Tampilkan data lain di sini --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="card-footer text-end">
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>