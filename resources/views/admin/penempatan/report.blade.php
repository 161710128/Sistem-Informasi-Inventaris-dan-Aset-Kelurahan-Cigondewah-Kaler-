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
    <h1>Laporan Data Penempatan</h1>
    <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Kode</th>
            <th scope="col">Tanggal Penempatan</th>
            <th scope="col">Lokasi</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($penempatans as $penempatan)   
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $penempatan->inventaris->barang->nama_barang }}</td>
            <td>{{ $penempatan->kode_penempatan }}</td>
            <td>{{ $penempatan->tgl_penempatan }}</td>
            <td>{{ $penempatan->lokasi }}</td>
            <td>{{ $penempatan->keterangan }}</td>
          </tr>
          @endforeach
        </tbody>
</body>
</html>
