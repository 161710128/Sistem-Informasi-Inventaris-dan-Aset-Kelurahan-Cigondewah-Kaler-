@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mengubah data Supplier</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/supplier/{{ $supplier->slug }}" method="post" class="mb-5">
        @method('patch')
        @csrf        
        <div class="mb-3">
          <label for="kode_supplier" class="form-label">Kode</label>
          <input type="text" class="form-control @error('kode_supplier') is-invalid @enderror" id="kode_supplier" name="kode_supplier" value="{{ @old('kode_supplier', $supplier->kode_supplier) }}" disabled readonly>
          @error('kode_supplier')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>   
        <div class="mb-3">
          <label for="nama_supplier" class="form-label">Nama Pegawai</label>
          <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" id="nama_supplier" name="nama_supplier" autofocus value="{{ @old('nama_supplier', $supplier->nama_supplier) }}">
          @error('nama_supplier')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug', $supplier->slug) }}">
          @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ @old('alamat', $supplier->alamat) }}">
          @error('alamat')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>     
        <div class="mb-3">
          <label for="no_telepon" class="form-label">No Telepon</label>
          <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ @old('no_telepon', $supplier->no_telepon) }}">
          @error('no_telepon')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>     
        
        <button type="submit" class="btn btn-primary">Ubah</button>
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