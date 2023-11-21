@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mengubah data Kategori Barang</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/kategoribarang/{{ $kategori->slug }}" method="post" class="mb-5">
        @method('patch')
        @csrf        
        <div class="mb-3">
          <label for="kode_kategori" class="form-label">Kode</label>
          <input type="text" class="form-control @error('kode_kategori') is-invalid @enderror" id="kode_kategori" name="kode_kategori" value="{{ @old('kode_kategori', $kategori->kode_kategori) }}" disabled readonly>
          @error('kode_kategori')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>   
        <div class="mb-3">
          <label for="nama_kategori" class="form-label">Nama Kategori Barang</label>
          <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" autofocus value="{{ @old('nama_kategori', $kategori->nama_kategori) }}">
          @error('nama_kategori')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug', $kategori->slug) }}">
          @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>  
        
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>

</div>

<script>
  const nama_kategori = document.querySelector('#nama_kategori');
  const slug = document.querySelector('#slug');

  nama_kategori.addEventListener('change', function(){
    fetch('/admin/kategoribarang/checkSlug?nama_kategori=' + nama_kategori.value)
    .then(response => response.json())
    .then(data => slug.value = data.slug)
  });
</script>

@endsection