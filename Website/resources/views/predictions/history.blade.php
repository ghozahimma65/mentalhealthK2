@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Prediksi</h2>

    @if(count($history) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Usia</th>
                    <th>Gender</th>
                    <th>Severity</th>
                    <th>Diagnosis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item['created_at'] ?? now())->toDateTimeString() }}</td>
                    <td>{{ $item['features']['Age'] }}</td>
                    <td>{{ $item['features']['Gender'] }}</td>
                    <td>{{ $item['features']['Symptom_Severity'] }}</td>
                    <td>{{ $item['prediction'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada riwayat prediksi yang ditemukan.</p>
    @endif
</div>
@endsection
