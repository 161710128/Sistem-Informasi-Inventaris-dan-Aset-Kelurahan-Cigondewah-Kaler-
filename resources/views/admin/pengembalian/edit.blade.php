@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mengubah data Pengembalian</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/transaksi/pengembalian-barang/{{ $pengembalian->slug }}" method="post" class="mb-5">
        @method('patch')
        @csrf        
        <div class="mb-3">
          <label for="kode_pengembalian" class="form-label">Kode</label>
          <input type="text" class="form-control @error('kode_pengembalian') is-invalid @enderror" id="kode_pengembalian" name="kode_pengembalian" value="{{ @old('kode_pengembalian', $pengembalian->kode_pengembalian) }}" disabled readonly>
          @error('kode_pengembalian')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="peminjaman" class="form-label">Nama Barang</label>
          <select class="form-select" name="peminjaman_id" autofocus>
            @foreach ($peminjamans as $peminjaman) 
              @if(old('peminjaman_id', $pengembalian->peminjaman_id) == $peminjaman->id)
              <option value="{{ $peminjaman->id }}" selected>{{ $peminjaman->inventaris->barang->nama_barang }}</option>
              @else
              <option value="{{ $peminjaman->id }}">{{ $peminjaman->inventaris->barang->nama_barang }}</option>
              @endif
            @endforeach
          </select>
        </div>
        {{-- <div class="mb-3">
            <label for="tgl_pengembalian" class="form-label">Tanggal Transaksi Pengembalian</label>
            <input type="date" class="form-control @error('tgl_pengembalian') is-invalid @enderror"  id="tgl_pengembalian" name="tgl_pengembalian" value="{{ @old('tgl_pengembalian', $pengembalian->tgl_pengembalian) }}">
            @error('tgl_pengembalian')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div> --}}
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ @old('keterangan', $pengembalian->keterangan) }}">
            @error('keterangan')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
            @enderror
        </div>   
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"  value="{{ @old('slug', $pengembalian->slug) }}">
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
    const keterangan = document.querySelector('#keterangan');
    const slug = document.querySelector('#slug');
  
    keterangan.addEventListener('change', function(){
      fetch('/admin/transaksi/pengembalian-barang/checkSlug?keterangan=' + keterangan.value)
      .then(response => response.json())
      .then(data => slug.value = data.slug)
    });
  </script>

@endsection