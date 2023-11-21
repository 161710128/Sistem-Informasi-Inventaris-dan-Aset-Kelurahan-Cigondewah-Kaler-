@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Halaman Data Pengembalian Barang</h1>
</div>

@if (session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="table-responsive col-lg-10">
    <a href="/admin/transaksi/pengembalian-barang/create" class="btn btn-primary mb-3"><span data-feather="file-plus"></span></a>
    <a href="/admin/transaksi/pengembalian-barang/view-pdf" class="btn btn-success mb-3" target="_blank"><span data-feather="printer"></span></a>

    <div class="mb-3">
      <form id="search-form" action="/admin/transaksi/pengembalian-barang/" method="GET" class="d-flex">
            @if(request('pengembalian')) 
                <input type="hidden" name="pengembalian" value="{{ request('pengembalian') }}">
            @endif
          <input type="text" class="form-control me-2" placeholder="Cari pengembalian barang..." name="search" value="{{ request('search') }}">
          <button type="submit" class="btn btn-primary">Cari</button>
      </form>
  </div>

    <div class="scrollable-table">
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
            <td>{{ $index + $loop->iteration }}</td>
            <td>{{ $pengembalian->peminjaman->inventaris->barang->nama_barang }}</td>
            <td>{{ $pengembalian->kode_pengembalian }}</td>
            {{-- <td>{{ $pengembalian->tgl_pengembalian }}</td> --}}
            <td>{{ $pengembalian->keterangan }}</td>
            <td>
              <a href="/admin/transaksi/pengembalian-barang/{{ $pengembalian->slug }}" class="badge bg-info"><span data-feather="eye"></span></a>
              <a href="/admin/transaksi/pengembalian-barang/{{ $pengembalian->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
              <form action="/admin/transaksi/pengembalian-barang/{{ $pengembalian->slug }}" method="post" class="d-inline">
                @csrf
                @method('delete')
                <button class="badge bg-danger border-0" onclick="return confirm('Apakah kamu yakin ingin menghapus ini?')"><span data-feather="x-circle"></span></button>
              </form>
            </td>
          </tr>
          @endforeach

          <!-- Tombol Previous dan Next dalam baris tabel terakhir -->
          <tr>
            <td colspan="9">
              <div class="d-flex justify-content-between">
                @if ($pengembalians->onFirstPage())
                  <button class="btn btn-secondary" disabled>Previous</button>
                @else
                  <a href="{{ $pengembalians->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                @endif

                @if ($pengembalians->hasMorePages())
                  <a href="{{ $pengembalians->nextPageUrl() }}" class="btn btn-primary">Next</a>
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
                    $('#pengembalian-table').html(response);
                }
            });
        }
    });
</script>

