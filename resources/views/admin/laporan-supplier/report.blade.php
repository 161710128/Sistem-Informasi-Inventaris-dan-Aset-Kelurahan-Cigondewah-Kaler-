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
    <h1>Laporan Data Supplier</h1>
    <table class="table table-striped table-sm ">
        <thead>
          <tr>
            <th scope="col">no</th>
            <th scope="col">Kode</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">No Telepon</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($suppliers as $supplier)   
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $supplier->kode_supplier }}</td>
            <td>{{ $supplier->nama_supplier }}</td>
            <td>{{ $supplier->alamat }}</td>
            <td>{{ $supplier->no_telepon }}</td>
          </tr>
          @endforeach
  
        </tbody>
      </table>
</body>
</html>
