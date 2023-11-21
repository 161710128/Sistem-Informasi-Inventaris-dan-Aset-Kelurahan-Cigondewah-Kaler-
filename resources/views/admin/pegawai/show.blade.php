@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail data Pegawai</h1>
</div>

<div class="col-lg-8">
        <a href="/admin/pegawai" class="btn btn-success"> <span data-feather="arrow-left"></span> Kembali</a>
        <a href="/admin/pegawai/{{ $pegawai->slug }}/edit" class="btn btn-warning"> <span data-feather="edit"></span> Edit</a>
        <form action="/admin/pegawai/{{ $pegawai->slug }}" method="post" class="d-inline">
            @csrf
            {{-- yang tadinya method post menjadi method delete, untuk menuju ke function delete di controller --}}
            @method('delete')
            
            <button class="btn btn-danger " onclick="return confirm('Are you sure you want to delete this')"><span data-feather="x-circle"></span>Delete</button>
        </form>

        <div class="mt-3">
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
          <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" name="nama_pegawai" autofocus value="{{ @old('nama_pegawai', $pegawai->nama_pegawai) }}"disabled readonly>
          @error('nama_pegawai')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug', $pegawai->slug) }}"disabled readonly>
          @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="jabatan" class="form-label">Jabatan</label>
          <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ @old('jabatan', $pegawai->jabatan) }}"disabled readonly>
          @error('jabatan')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

</div>



@endsection