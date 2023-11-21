@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mengubah data Pegawai</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/pegawai/{{ $pegawai->slug }}" method="post" class="mb-5">
        @method('patch')
        @csrf        
        <div class="mb-3">
          <label for="kode_pegawai" class="form-label">Kode</label>
          <input type="text" class="form-control @error('kode_pegawai') is-invalid @enderror" id="kode_pegawai" name="kode_pegawai" value="{{ @old('kode_pegawai', $pegawai->kode_pegawai) }}" disabled readonly>
          @error('kode_pegawai')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>   
        <div class="mb-3">
          <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
          <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" name="nama_pegawai" autofocus value="{{ @old('nama_pegawai', $pegawai->nama_pegawai) }}">
          @error('nama_pegawai')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug', $pegawai->slug) }}">
          @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="jabatan" class="form-label">Jabatan</label>
          <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ @old('jabatan', $pegawai->jabatan) }}">
          @error('jabatan')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>     
        
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>

</div>

<script>
  const nama_pegawai = document.querySelector('#nama_pegawai');
  const slug = document.querySelector('#slug');

  nama_pegawai.addEventListener('change', function(){
    fetch('/admin/pegawai/checkSlug?nama_pegawai=' + nama_pegawai.value)
    .then(response => response.json())
    .then(data => slug.value = data.slug)
  });
</script>

@endsection