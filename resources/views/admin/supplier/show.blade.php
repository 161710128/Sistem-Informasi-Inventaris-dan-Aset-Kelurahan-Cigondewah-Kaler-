@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail data Supplier</h1>
</div>

<div class="col-lg-8">
        <a href="/admin/supplier" class="btn btn-success"> <span data-feather="arrow-left"></span> Kembali</a>
        <a href="/admin/supplier/{{ $supplier->slug }}/edit" class="btn btn-warning"> <span data-feather="edit"></span> Edit</a>
        <form action="/admin/supplier/{{ $supplier->slug }}" method="post" class="d-inline">
            @csrf
            {{-- yang tadinya method post menjadi method delete, untuk menuju ke function delete di controller --}}
            @method('delete')
            
            <button class="btn btn-danger " onclick="return confirm('Are you sure you want to delete this')"><span data-feather="x-circle"></span>Delete</button>
        </form>

        <div class="mt-3">
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
          <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" id="nama_supplier" name="nama_supplier" autofocus value="{{ @old('nama_supplier', $supplier->nama_supplier) }}"disabled readonly>
          @error('nama_supplier')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug', $supplier->slug) }}"disabled readonly>
          @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ @old('alamat', $supplier->alamat) }}"disabled readonly>
          @error('alamat')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="no_telepon" class="form-label">No Telepon</label>
          <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ @old('no_telepon', $supplier->no_telepon) }}"disabled readonly>
          @error('no_telepon')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

</div>



@endsection