@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Halaman Data Inventaris</h1>
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
    $url = ($role === 'lurah') ? '/lurah/inventaris' : '/admin/inventaris';
    @endphp
    <a href="{{ $url }}/view-pdf" class="btn btn-success mb-3" target="_blank"><span data-feather="printer"></span></a>

    <div class="mb-3">
      <form id="search-form" action="/admin/inventaris/" method="GET" class="d-flex">
          <input type="text" class="form-control me-2" placeholder="Cari data Inventaris..." name="search" value="{{ request('search') }}">
          <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </div>

    <div class="scrollable-table">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Kode</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Tanggal Transaksi Pengadaan</th>
            <th scope="col">Supplier</th>
            <th scope="col">Jumlah</th>
            <th scope="col">harga</th>
            <th scope="col">Jumlah Biaya</th>
            <th scope="col">Kondisi</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($inventaris as $inventory)   
          <tr>
            <td>{{ $index + $loop->iteration }}</td>
            <td>{{ $inventory->kode_inventaris }}</td>
            <td>{{ $inventory->barang->nama_barang }}</td>
            <td>{{ $inventory->transaksiPengadaan->tgl_transaksi_pengadaan }}</td>
            <td>{{ $inventory->transaksiPengadaan->supplier->nama_supplier }}</td>
            <td>{{ $inventory->barang->jumlah_barang }}</td>
            <td>{{ number_format($inventory->barang->harga, 2, ',', '.') }}</td>
            <td>{{ number_format($inventory->barang->total_biaya, 2, ',', '.') }}</td>
            <td>{{ $inventory->kondisi }}</td>
            <td>{{ $inventory->status }}</td>
            {{-- <td>
              <a href="/admin/pegawai/{{ $pegawai->slug }}" class="badge bg-info"><span data-feather="eye"></span></a>
              <a href="/admin/pegawai/{{ $pegawai->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
              <form action="/admin/pegawai/{{ $pegawai->slug }}" method="post" class="d-inline">
                @csrf
                @method('delete')
                <button class="badge bg-danger border-0" onclick="return confirm('Apakah kamu yakin ingin menghapus ini?')"><span data-feather="x-circle"></span></button>
              </form>
            </td> --}}
          </tr>
          @endforeach

          <!-- Tombol Previous dan Next dalam baris tabel terakhir -->
          <tr>
            <td colspan="10">
              <div class="d-flex justify-content-between">
                @if ($inventaris->onFirstPage())
                  <button class="btn btn-secondary" disabled>Previous</button>
                @else
                  <a href="{{ $inventaris->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                @endif

                @if ($inventaris->hasMorePages())
                  <a href="{{ $inventaris->nextPageUrl() }}" class="btn btn-primary">Next</a>
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
                    $('#inventaris-table').html(response);
                }
            });
        }
    });
</script>

