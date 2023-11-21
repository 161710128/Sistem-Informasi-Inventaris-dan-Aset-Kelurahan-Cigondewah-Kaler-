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
    <h1>Laporan Data Pemeliharaan</h1>
    <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Kode</th>
            <th scope="col">Tanggal Pemeliharaan</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Biaya Pemeliharaan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pemeliharaans as $pemeliharaan)   
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pemeliharaan->inventaris->barang->nama_barang }}</td>
            <td>{{ $pemeliharaan->kode_pemeliharaan }}</td>
            <td>{{ $pemeliharaan->tgl_pemeliharaan }}</td>
            <td>{{ $pemeliharaan->keterangan }}</td>
            <td>{{ $pemeliharaan->biaya_pemeliharaan }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
</body>
</html>
