@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Halaman Laporan Peminjaman Barang</h1>
</div>

@if (session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="table-responsive col-lg-10">
    <a href="/admin/transaksi/peminjaman-barang/view-pdf" class="btn btn-success mb-3" target="_blank"><span data-feather="printer"></span></a>

    <div class="mb-3">
      <form id="search-form" action="/admin/transaksi/peminjaman-barang/" method="GET" class="d-flex">
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
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Kode</th>
            <th scope="col">Tanggal Peminjaman</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($peminjamans as $peminjaman)   
          <tr>
            <td>{{ $index + $loop->iteration }}</td>
            <td>{{ $peminjaman->inventaris->barang->nama_barang }}</td>
            <td>{{ $peminjaman->pegawai->nama_pegawai }}</td>
            <td>{{ $peminjaman->kode_peminjman }}</td>
            <td>{{ $peminjaman->tgl_peminjaman }}</td>
            <td>{{ $peminjaman->keterangan }}</td>
          </tr>
          @endforeach

          <!-- Tombol Previous dan Next dalam baris tabel terakhir -->
          <tr>
            <td colspan="9">
              <div class="d-flex justify-content-between">
                @if ($peminjamans->onFirstPage())
                  <button class="btn btn-secondary" disabled>Previous</button>
                @else
                  <a href="{{ $peminjamans->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                @endif

                @if ($peminjamans->hasMorePages())
                  <a href="{{ $peminjamans->nextPageUrl() }}" class="btn btn-primary">Next</a>
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
                    $('#peminjaman-table').html(response);
                }
            });
        }
    });
</script>

