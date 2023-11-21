<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Data Barang</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Spesifikasi</th>
                    <th>Harga</th>
                    <th>Satuan</th>
                    <th>Jumlah Barang</th>
                    <th>Jumlah Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $barang)   
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->merk }}</td>
                    <td>{{ $barang->spesifikasi }}</td>
                    <td>Rp {{ number_format($barang->harga, 2, ',', '.') }}</td>
                    <td>{{ $barang->satuan }}</td>
                    <td>{{ $barang->jumlah_barang }}</td>
                    <td>Rp {{ number_format($barang->total_biaya, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
