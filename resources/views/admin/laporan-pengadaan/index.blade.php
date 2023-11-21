@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">ini halaman Laporan Pengadaan Barang </h1>
    
</div>
@if (session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="table-responsive col-lg-10">
  @php
  $role = Auth::user()->role;
  $url = ($role === 'lurah') ? '/lurah/laporan/pengadaan' : '/admin/laporan/pengadaan';
  @endphp
    <a href="{{ $url }}/view-pdf" class="btn btn-success mb-3" target="_blank"><span data-feather="printer"></span></a>

    <div class="mb-3">
        <form id="search-form" action="/admin/laporan/pengadaan" method="GET" class="d-flex">
            <input type="text" class="form-control me-2" placeholder="Cari Transaksi barang..." name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>
      
      <div class="scrollable-table">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Kode Transaksi Pengadaan</th>
              <th scope="col">Supplier</th>
              <th scope="col">Tanggal Transaksi Pengadaan</th>
              <th scope="col">Jenis Pengadaan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pengadaans as $pengadaan)   
            <tr>
              <td>{{ $index + $loop->iteration }}</td>
              <td>{{ $pengadaan->kode_transaksi_pengadaan }}</td>
              <td>{{ $pengadaan->supplier->nama_supplier }}</td>
              <td>{{ $pengadaan->tgl_transaksi_pengadaan }}</td>
              <td>{{ $pengadaan->jenis_pengadaan }}</td>
            </tr>
            @endforeach
  
            <!-- Tombol Previous dan Next dalam baris tabel terakhir -->
            <tr>
              <td colspan="9">
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
                    $('#pengadaan-table').html(response);
                }
            });
        }
    });
</script>