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
            padding: 4px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Data Inventaris</h1>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode</th>
          <th scope="col">Nama Barang</th>
          <th scope="col">Tanggal Transaksi Pengadaan</th>
          <th scope="col">Supplier</th>
          <th scope="col">Jumlah</th>
          <th scope="col">harga</th>
          <th scope="col">Jumlah Biaya</th>
          <th scope="col">Kondisi</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($inventaris as $inventory)   
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $inventory->kode_inventaris }}</td>
          <td>{{ $inventory->barang->nama_barang }}</td>
          <td>{{ $inventory->transaksiPengadaan->tgl_transaksi_pengadaan }}</td>
          <td>{{ $inventory->transaksiPengadaan->supplier->nama_supplier }}</td>
          <td>{{ $inventory->barang->jumlah_barang }}</td>
          <td>{{ number_format($inventory->barang->harga, 2, ',', '.') }}</td>
          <td>{{ number_format($inventory->barang->total_biaya, 2, ',', '.') }}</td>
          <td>{{ $inventory->kondisi }}</td>
          <td>{{ $inventory->status }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
