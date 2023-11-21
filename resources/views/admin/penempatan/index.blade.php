@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Halaman Data Penempatan Barang</h1>
</div>

@if (session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="table-responsive col-lg-10">
    <a href="/admin/transaksi/penempatan-barang/create" class="btn btn-primary mb-3"><span data-feather="file-plus"></span></a>
    <a href="/admin/transaksi/penempatan-barang/view-pdf" class="btn btn-success mb-3" target="_blank"><span data-feather="printer"></span></a>
    {{-- <div class="mb-3">
      <form action="/admin/pegawai/" method="GET" id="search-form" class="d-flex">
        
          <input type="text" class="form-control me-2" placeholder="Cari nama pegawai..." name="search" value="{{ request('search') }}">
          <button type="search" class="btn btn-primary">Cari</button>
          
      </form>
    </div> --}}

    <div class="mb-3">
      <form id="search-form" action="/admin/transaksi/penempatan-barang/" method="GET" class="d-flex">
            @if(request('barang')) 
                <input type="hidden" name="barang" value="{{ request('barang') }}">
            @endif
          <input type="text" class="form-control me-2" placeholder="Cari lokasi..." name="search" value="{{ request('search') }}">
          <button type="submit" class="btn btn-primary">Cari</button>
      </form>
  </div>

    <div class="scrollable-table">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Kode</th>
            <th scope="col">Tanggal Penempatan</th>
            <th scope="col">Lokasi</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($penempatans as $penempatan)   
          <tr>
            <td>{{ $index + $loop->iteration }}</td>
            <td>{{ $penempatan->inventaris->barang->nama_barang }}</td>
            <td>{{ $penempatan->kode_penempatan }}</td>
            <td>{{ $penempatan->tgl_penempatan }}</td>
            <td>{{ $penempatan->lokasi }}</td>
            <td>{{ $penempatan->keterangan }}</td>
            <td>
              <a href="/admin/transaksi/penempatan-barang/{{ $penempatan->slug }}" class="badge bg-info"><span data-feather="eye"></span></a>
              <a href="/admin/transaksi/penempatan-barang/{{ $penempatan->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
              <form action="/admin/transaksi/penempatan-barang/{{ $penempatan->slug }}" method="post" class="d-inline">
                @csrf
                @method('delete')
                <button class="badge bg-danger border-0" onclick="return confirm('Apakah kamu yakin ingin menghapus ini?')"><span data-feather="x-circle"></span></button>
              </form>
            </td>
          </tr>
          @endforeach

          <!-- Tombol Previous dan Next dalam baris tabel terakhir -->
          <tr>
            <td colspan="7">
              <div class="d-flex justify-content-between">
                @if ($penempatans->onFirstPage())
                  <button class="btn btn-secondary" disabled>Previous</button>
                @else
                  <a href="{{ $penempatans->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                @endif

                @if ($penempatans->hasMorePages())
                  <a href="{{ $penempatans->nextPageUrl() }}" class="btn btn-primary">Next</a>
                @else
                  <button class="btn btn-secondary" disabled>Next</button>
                @endif
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var searchForm = $('#search-form');
        var searchInput = searchForm.find('input[name="search"]');
        var searchUrl = searchForm.data('url');

        searchInput.on('input', function() {
            var keyword = $(this).val();
            fetchSearchResults(keyword);
        });

        function fetchSearchResults(keyword) {
            $.ajax({
                url: searchUrl,
                type: 'GET',
                data: { search: keyword },
                success: function(response) {
                    $('#penempatan-table').html(response);
                }
            });
        }
    });
</script>

