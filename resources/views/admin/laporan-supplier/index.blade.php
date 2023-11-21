@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">ini halaman data Supplier </h1>
    
</div>
@if (session()->has('success'))
  <div class="alert alert-success col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

  <div class="table-responsive col-lg-10">
    <a href="/admin/laporan/supplier/view-pdf" class="btn btn-success mb-3" target="_blank"><span data-feather="printer"></span></a>

    <div class="mb-3">
      <form id="search-form" action="/admin/laporan/supplier/" method="GET" class="d-flex">
          <input type="text" class="form-control me-2" placeholder="Cari nama supplier..." name="search" value="{{ request('search') }}">
          <button type="submit" class="btn btn-primary">Cari</button>
      </form>
  </div>

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

        <!-- Tombol Previous dan Next dalam baris tabel terakhir -->
        <tr>
            <td colspan="5">
              <div class="d-flex justify-content-between">
                @if ($suppliers->onFirstPage())
                  <button class="btn btn-secondary" disabled>Previous</button>
                @else
                  <a href="{{ $suppliers->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                @endif

                @if ($suppliers->hasMorePages())
                  <a href="{{ $suppliers->nextPageUrl() }}" class="btn btn-primary">Next</a>
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
                    $('#supplier-table').html(response);
                }
            });
        }
    });
</script>