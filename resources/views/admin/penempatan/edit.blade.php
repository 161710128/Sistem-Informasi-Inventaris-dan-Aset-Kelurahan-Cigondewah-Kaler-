@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mengubah data Penempatan</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/transaksi/penempatan-barang/{{ $penempatan->slug }}" method="post" class="mb-5">
        @method('patch')
        @csrf        
        <div class="mb-3">
          <label for="kode_penempatan" class="form-label">Kode</label>
          <input type="text" class="form-control @error('kode_penempatan') is-invalid @enderror" id="kode_penempatan" name="kode_penempatan" value="{{ @old('kode_penempatan', $penempatan->kode_penempatan) }}" disabled readonly>
          @error('kode_penempatan')
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
            <label for="tgl_penempatan" class="form-label">Tanggal Transaksi Penempatan</label>
            <input type="date" class="form-control @error('tgl_penempatan') is-invalid @enderror"  id="tgl_penempatan" name="tgl_penempatan" value="{{ @old('tgl_penempatan', $penempatan->tgl_penempatan) }}">
            @error('tgl_penempatan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ @old('lokasi', $penempatan->lokasi) }}">
            @error('lokasi')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>     
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"  value="{{ @old('slug', $penempatan->slug) }}">
            @error('slug')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ @old('keterangan', $penempatan->keterangan) }}">
            @error('keterangan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
        </div>   
        
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>

</div>

<script>
  const lokasi = document.querySelector('#lokasi');
  const slug = document.querySelector('#slug');

  lokasi.addEventListener('change', function(){
    fetch('/admin/transaksi/penempatan-barang/checkSlug?lokasi=' + lokasi.value)
    .then(response => response.json())
    .then(data => slug.value = data.slug)
  });
</script>

@endsection