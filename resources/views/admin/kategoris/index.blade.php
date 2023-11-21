@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">ini halaman data Kategori Barang </h1>
    
</div>
@if (session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

  <div class="table-responsive col-lg-10">
    <a href="/admin/kategoribarang/create" class="btn btn-primary mb-3">Tambah Kategori</a>
    <table class="table table-striped table-sm ">
      <thead>
        <tr>
          <th scope="col">no</th>
          <th scope="col">Kode</th>
          <th scope="col">Nama</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($kategoris as $kategori)   
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $kategori->kode_kategori }}</td>
          <td>{{ $kategori->nama_kategori }}</td>
            <td>
                <a href="/admin/kategoribarang/{{ $kategori->slug }}" class="badge bg-info"><span data-feather="eye"></span></a>
                <a href="/admin/kategoribarang/{{ $kategori->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                <form action="/admin/kategoribarang/{{ $kategori->slug }}" method="post" class="d-inline">
                  @csrf
                  @method('delete')
                  <button class="badge bg-danger border-0" onclick="return confirm('apakah kamu yakin hapus ini?')"><span data-feather="x-circle"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>

@endsection