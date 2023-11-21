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
    <h1>Laporan Data Pengembalian</h1>
    <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Peminjaman</th>
            <th scope="col">Kode</th>
            {{-- <th scope="col">Tanggal Pengembalian</th> --}}
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pengembalians as $pengembalian)   
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pengembalian->peminjaman->inventaris->barang->nama_barang }}</td>
            <td>{{ $pengembalian->kode_pengembalian }}</td>
            {{-- <td>{{ $pengembalian->tgl_pengembalian }}</td> --}}
            <td>{{ $pengembalian->keterangan }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
</body>
</html>
