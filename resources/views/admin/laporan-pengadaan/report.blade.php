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
    <h1>Laporan Data Transaksi Pengadaan</h1>
    <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Kode Transaksi Pengadaan</th>
            <th scope="col">Supplier</th>
            <th scope="col">Tanggal Transaksi Pengadaan</th>
            <th scope="col">Jenis Pengadaan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pengadaans as $pengadaan)   
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pengadaan->kode_transaksi_pengadaan }}</td>
            <td>{{ $pengadaan->supplier->nama_supplier }}</td>
            <td>{{ $pengadaan->tgl_transaksi_pengadaan }}</td>
            <td>{{ $pengadaan->jenis_pengadaan }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
</body>
</html>
