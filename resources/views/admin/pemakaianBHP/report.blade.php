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
    <h1>Laporan Data Pemakaian Barang Habis Pakai</h1>
    <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Kode</th>
            <th scope="col">Tanggal Pemakaian</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($barangHabisPakais as $pemakaian)   
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pemakaian->inventaris->barang->nama_barang }}</td>
            <td>{{ $pemakaian->pegawai->nama_pegawai }}</td>
            <td>{{ $pemakaian->kode_barang_habis_pakai }}</td>
            <td>{{ $pemakaian->tgl_pemakaian_barang_habis_pakai }}</td>
            <td>{{ $pemakaian->keterangan }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
</body>
</html>
