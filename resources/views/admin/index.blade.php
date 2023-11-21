@extends('admin.layouts.main')

@section('container')

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome back, {{ auth()->user()->role }} </h1>
    
  </div>

  
  <!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .bodi {
            font-family: 'Poppins', sans-serif;
            background-color: #e8e8e8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .box {
            width: 250px;
            height: 200px;
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .box:hover {
            transform: scale(1.05);
        }
        .number {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="bodi">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <div class="container">
            <div class="box" style="background-color: #ff6b6b;">
              <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px;">Inventaris</h2>
              <p class="number">Jumlah: {{ $jumlahInventaris }}</p>
            </div>
            <div class="box" style="background-color: #1dd1a1;">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px;">Transaksi Pengadaan</h2>
                <p style="font-size: 18px;">Jumlah:  {{ $jumlahTransaksi }}</p>
            </div>
            {{-- <div class="box" style="background-color: #ff6b6b;">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px;">Peminjaman</h2>
                <p style="font-size: 18px;">Jumlah: 300</p>
            </div> --}}
            <div class="box" style="background-color: #feca57;">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px;">Barang</h2>
                <p style="font-size: 18px;">Jumlah: {{ $jumlahBarang }}</p>
            </div>
            {{-- <div class="box" style="background-color: #1dd1a1;">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px;">Transaksi Pengadaan</h2>
                <p style="font-size: 18px;">Jumlah: 200</p>
            </div>
            <div class="box" style="background-color: #feca57;">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 24px;">Peminjaman</h2>
                <p style="font-size: 18px;">Jumlah: 300</p>
            </div> --}}
            <!-- Tambahkan lebih banyak kotak di sini -->
        </div>
    </div>
</body>
</html>



@endsection