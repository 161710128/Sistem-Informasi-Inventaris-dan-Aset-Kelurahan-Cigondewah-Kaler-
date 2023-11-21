@extends('admin/layouts.main')
@section('container')
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mengubah data Pemeliharaan</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/transaksi/pemeliharaan-barang/{{ $pemeliharaan->slug }}" method="post" class="mb-5">
        @method('patch')
        @csrf        
        <div class="mb-3">
          <label for="kode_pemeliharaan" class="form-label">Kode</label>
          <input type="text" class="form-control @error('kode_pemeliharaan') is-invalid @enderror" id="kode_pemeliharaan" name="kode_pemeliharaan" value="{{ @old('kode_pemeliharaan', $pemeliharaan->kode_pemeliharaan) }}" disabled readonly>
          @error('kode_pemeliharaan')
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
            <label for="tgl_pemeliharaan" class="form-label">Tanggal Transaksi pemeliharaan</label>
            <input type="date" class="form-control @error('tgl_pemeliharaan') is-invalid @enderror"  id="tgl_pemeliharaan" name="tgl_pemeliharaan" value="{{ @old('tgl_pemeliharaan', $pemeliharaan->tgl_pemeliharaan) }}">
            @error('tgl_pemeliharaan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>
          <div class="mb-3">
              <label for="keterangan" class="form-label">Keterangan</label>
              <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ @old('keterangan', $pemeliharaan->keterangan) }}">
              @error('keterangan')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
          </div>   
          <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"  value="{{ @old('slug', $pemeliharaan->slug) }}">
            @error('slug')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>
        <div class="mb-3">
          <label for="biaya_pemeliharaan" class="form-label">Biaya Pemeliharaan</label>
          <input type="text" class="form-control @error('biaya_pemeliharaan') is-invalid @enderror" id="biaya_pemeliharaan" name="biaya_pemeliharaan" value="{{ @old('biaya_pemeliharaan', $pemeliharaan->biaya_pemeliharaan) }}">
          @error('biaya_pemeliharaan')
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
    fetch('/admin/transaksi/pemeliharaan-barang/checkSlug?keterangan=' + keterangan.value)
    .then(response => response.json())
    .then(data => slug.value = data.slug)
  });
</script>

@endsection