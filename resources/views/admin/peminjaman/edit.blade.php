@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mengubah data Peminjaman</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/transaksi/peminjaman-barang/{{ $peminjaman->slug }}" method="post" class="mb-5">
        @method('patch')
        @csrf        
        <div class="mb-3">
          <label for="kode_peminjman" class="form-label">Kode</label>
          <input type="text" class="form-control @error('kode_peminjman') is-invalid @enderror" id="kode_peminjman" name="kode_peminjman" value="{{ @old('kode_peminjman', $peminjaman->kode_peminjman) }}" disabled readonly>
          @error('kode_peminjman')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="inventaris" class="form-label">Nama Barang</label>
          <select class="form-select" name="inventaris_id">
              @foreach ($inventory as $inventaris) 
              @if(old('inventaris_id') == $inventaris->id)
              <option value="{{ $inventaris->id }}" selected>{{ $inventaris->barang->nama_barang }} - {{ $inventaris->status }}</option>
              @else
              <option value="{{ $inventaris->id }}">{{ $inventaris->barang->nama_barang }} - {{ $inventaris->status }}</option>
              @endif
              @endforeach
          </select>
      </div>
        <div class="mb-3">
          <label for="pegawai" class="form-label">Nama Pegawai</label>
          <select class="form-select" name="pegawai_id" autofocus>
            @foreach ($pegawais as $pegawai) 
              @if(old('pegawai_id', $peminjaman->pegawai_id) == $pegawai->id)
              <option value="{{ $pegawai->id }}" selected>{{ $pegawai->nama_pegawai }}</option>
              @else
              <option value="{{ $pegawai->id }}">{{ $pegawai->nama_pegawai }}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="mb-3">
            <label for="tgl_peminjaman" class="form-label">Tanggal Transaksi peminjaman</label>
            <input type="date" class="form-control @error('tgl_peminjaman') is-invalid @enderror"  id="tgl_peminjaman" name="tgl_peminjaman" value="{{ @old('tgl_peminjaman', $peminjaman->tgl_peminjaman) }}">
            @error('tgl_peminjaman')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>  
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ @old('keterangan', $peminjaman->keterangan) }}">
            @error('keterangan')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
            @enderror
        </div>   
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"  value="{{ @old('slug', $peminjaman->slug) }}">
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
      fetch('/admin/transaksi/peminjaman-barang/checkSlug?keterangan=' + keterangan.value)
      .then(response => response.json())
      .then(data => slug.value = data.slug)
    });
  </script>

@endsection