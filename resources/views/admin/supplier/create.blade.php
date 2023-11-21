@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Membuat data Supplier Baru</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/supplier" method="post" class="mb-5">
        @csrf
        <div class="mb-3">
          <label for="nama_supplier" class="form-label">Nama Supplier</label>
          <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" autofocus value="{{ @old('nama_supplier') }}">
          {{-- @error('nama_supplier')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror --}}
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug') }}" disabled readonly>
          @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ @old('alamat') }}">
          @error('alamat')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>        
        <div class="mb-3">
          <label for="no_telepon" class="form-label">No Telepon</label>
          <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ @old('no_telepon') }}">
          @error('no_telepon')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>        
        
        <button type="submit" class="btn btn-primary">Tambah Supplier</button>
    </form>

</div>

<script>
  const nama_supplier = document.querySelector('#nama_supplier');
  const slug = document.querySelector('#slug');

  nama_supplier.addEventListener('change', function(){
    fetch('/admin/supplier/checkSlug?nama_supplier=' + nama_supplier.value)
    .then(response => response.json())
    .then(data => slug.value = data.slug)
  });
</script>

@endsection