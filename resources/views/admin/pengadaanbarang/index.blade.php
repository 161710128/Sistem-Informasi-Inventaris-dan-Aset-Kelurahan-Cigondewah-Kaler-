@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">ini halaman Transaksi Pengadaan </h1>
    
</div>
@if (session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

  <div class="table-responsive col-lg-10">
    <a href="/admin/transaksi/pengadaan-barang/create" class="btn btn-primary mb-3">Tambah data</a>
    <table class="table table-striped table-sm ">
      <thead>
        <tr>
          <th scope="col">no</th>
          <th scope="col">Tanggal Transaksi</th>
          <th scope="col">Kode Transaksi</th>
          <th scope="col">Kode Label</th>
          <th scope="col">Supplier</th>
          <th scope="col">Nama Barang</th>
          <th scope="col">Harga Barang</th>
          <th scope="col">Qty Barang</th>
          <th scope="col">Total Biaya</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pengadaans as $pengadaan)   
        <tr>
          <td>{{ $index + $loop->iteration }}</td>
          <td>{{ $pengadaan->transaksiPengadaan->tgl_transaksi_pengadaan }}</td>
          <td>{{ $pengadaan->kode_pengadaan_item }}</td>
          <td>{{ $pengadaan->barang->kode_label }}</td>
          <td>{{ $pengadaan->transaksiPengadaan->supplier->nama_supplier }}</td>
          <td>{{ $pengadaan->barang->nama_barang }}</td>
          <td>{{ number_format($pengadaan->barang->harga, 2, ',', '.') }}</td>
          <td>{{ $pengadaan->barang->jumlah_barang }}</td>
          <td>{{ number_format($pengadaan->barang->total_biaya, 2, ',', '.')  }}</td>
            <td>
                {{-- <a href="/admin/supplier/{{ $supplier->slug }}" class="badge bg-info"><span data-feather="eye"></span></a> --}}
                <a href="/admin/transaksi/pengadaan-barang/{{ $pengadaan->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                <form action="/admin/transaksi/pengadaan-barang/{{ $pengadaan->slug }}" method="post" class="d-inline">
                  @csrf
                  @method('delete')
                  <button class="badge bg-danger border-0" onclick="return confirm('apakah kamu yakin hapus ini?')"><span data-feather="x-circle"></span></button>
                </form>
            </td>
        </tr>
        @endforeach

        <tr>
          <td colspan="10">
            <div class="d-flex justify-content-between">
              @if ($pengadaans->onFirstPage())
                <button class="btn btn-secondary" disabled>Previous</button>
              @else
                <a href="{{ $pengadaans->previousPageUrl() }}" class="btn btn-primary">Previous</a>
              @endif

              @if ($pengadaans->hasMorePages())
                <a href="{{ $pengadaans->nextPageUrl() }}" class="btn btn-primary">Next</a>
              @else
                <button class="btn btn-secondary" disabled>Next</button>
              @endif
            </div>
          </td>
        </tr>

      </tbody>
    </table>
</div>

@endsection