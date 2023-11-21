@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Membuat data Pengembalian Barang</h1>
</div>

<div class="col-lg-8">
    <form action="/admin/transaksi/pengembalian-barang/" method="post" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="peminjaman" class="form-label">Peminjaman</label>
            <select class="form-select" name="peminjaman_id">
                @foreach ($peminjamans as $peminjaman) 
                @if(old('peminjaman_id') == $peminjaman->id)
                <option value="{{ $peminjaman->id }}" selected>{{ $peminjaman->inventaris->barang->nama_barang }}</option>
                @else
                <option value="{{ $peminjaman->id }}">{{ $peminjaman->inventaris->barang->nama_barang }}</option>
                @endif
                @endforeach
            </select>
        </div>
        {{-- <div class="mb-3">
            <label for="tgl_pengembalian" class="form-label">Tanggal Transaksi Pengembalian</label>
            <input type="date" class="form-control @error('tgl_pengembalian') is-invalid @enderror" id="tgl_pengembalian" name="tgl_pengembalian" value="{{ @old('tgl_pengembalian') }}">
            @error('tgl_pengembalian')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
        </div> --}}
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" autofocus value="{{ @old('keterangan') }}" >
            @error('keterangan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug') }}" disabled readonly>
            @error('slug')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <div class="mb-3">
            <label for="status" class="form-label">status </label>
            <select class="form-select" name="status">
              
              
              <option value="dipinjam" {{ @old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }} >Dipinjam</option>
              
              <option value="kembali" {{ @old('status', $peminjaman->status) == 'kembali' ? 'selected' : '' }} >Kembali</option>            
              
            </select>
          </div>     --}}

          {{-- <div class="mb-3">
            <label for="status" class="form-label">Status Peminjaman</label>
            <select class="form-select" name="peminjaman_id">
                @foreach ($peminjamans as $peminjaman) 
                @if(old('peminjaman_id') == $peminjaman->id)
                <option value="{{ $peminjaman->id }}" selected>{{ $peminjaman->status }}</option>
                @else
                <option value="{{ $peminjaman->id }}">{{ $peminjaman->status }}</option>
                @endif
                @endforeach
            </select>
        </div> --}}
        
        
        <button type="submit" class="btn btn-primary">Tambah</button>
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