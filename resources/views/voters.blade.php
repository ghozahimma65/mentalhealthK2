<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Voters</title>
</head>
<body>
    <h1>Daftar Pemilih</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th> <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($voters as $key => $voter)
                <tr>
                    <td>{{ $key + 1 }}</td> <td>{{ $voter->name }}</td>
                    <td>{{ $voter->email }}</td>
                    <td>{{ $voter->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>