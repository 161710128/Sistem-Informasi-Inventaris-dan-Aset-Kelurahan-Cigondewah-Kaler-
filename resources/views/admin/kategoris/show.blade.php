@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail data Kategori</h1>
</div>

<div class="col-lg-8">
        <a href="/admin/kategoribarang" class="btn btn-success"> <span data-feather="arrow-left"></span> Kembali</a>
        <a href="/admin/kategoribarang/{{ $kategori->slug }}/edit" class="btn btn-warning"> <span data-feather="edit"></span> Edit</a>
        <form action="/admin/kategoribarang/{{ $kategori->slug }}" method="post" class="d-inline">
            @csrf
            {{-- yang tadinya method post menjadi method delete, untuk menuju ke function delete di controller --}}
            @method('delete')
            
            <button class="btn btn-danger " onclick="return confirm('Are you sure you want to delete this')"><span data-feather="x-circle"></span>Delete</button>
        </form>

        <div class="mt-3">
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
          <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" autofocus value="{{ @old('nama_kategori', $kategori->nama_kategori) }}"disabled readonly>
          @error('nama_kategori')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug', $kategori->slug) }}"disabled readonly>
          @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

</div>



@endsection