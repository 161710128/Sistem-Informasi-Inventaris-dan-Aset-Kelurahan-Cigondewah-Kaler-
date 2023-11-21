<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        h1 {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Data Pegawai</h1>
    <table>
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode</th>
                <th scope="col">Nama</th>
                <th scope="col">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawais as $pegawai)   
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pegawai->kode_pegawai }}</td>
                <td>{{ $pegawai->nama_pegawai }}</td>
                <td>{{ $pegawai->jabatan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
