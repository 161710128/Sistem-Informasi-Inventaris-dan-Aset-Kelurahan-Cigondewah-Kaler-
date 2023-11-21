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
    <h1>Laporan Data Peminjaman</h1>
    <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Kode</th>
            <th scope="col">Tanggal Peminjaman</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($peminjamans as $peminjaman)   
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $peminjaman->inventaris->barang->nama_barang }}</td>
            <td>{{ $peminjaman->pegawai->nama_pegawai }}</td>
            <td>{{ $peminjaman->kode_peminjman }}</td>
            <td>{{ $peminjaman->tgl_peminjaman }}</td>
            <td>{{ $peminjaman->keterangan }}</td>
          </tr>
          @endforeach

          <!-- Tombol Previous dan Next dalam baris tabel terakhir -->
          
        </tbody>
      </table>
</body>
</html>
