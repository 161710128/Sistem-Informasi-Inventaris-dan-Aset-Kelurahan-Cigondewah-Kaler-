@extends('admin.layouts.main')

@section('container')
<div class="scrolling-container-wrapper">
  <div class="scrolling-container p-4 rounded shadow">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Transaksi Pengadaan</h1>
    </div>

    <div class="col-lg-8">
        <form action="/admin/transaksi/pengadaan-barang/{{ $pengadaan->slug }}" method="post" class="mb-5">
          @method('patch')
          @csrf
           <!-- Data Barang -->
           <h4>Data Barang</h4>
           <hr>
            <div class="mb-3">
              <label for="nama_barang" class="form-label">Nama Barang</label>
              <input type="text" class="form-control" id="nama_barang" name="nama_barang" autofocus value="{{ @old('nama_barang', $pengadaan->barang->nama_barang) }}">
              {{-- @error('nama_barang')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror --}}
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autofocus value="{{ @old('slug', $pengadaan->barang->slug) }}">
                @error('slug')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                @enderror
              </div>
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select" name="kategori_barang_id">
                @foreach ($kategoris as $kategori) 
                  @if(old('kategori_barang_id', $pengadaan->barang->kategori_barang_id) == $kategori->id)
                  <option value="{{ $kategori->id }}" selected>{{ $kategori->nama_kategori }}</option>
                  @else
                  <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="merk" class="form-label">Merk</label>
              <input type="text" class="form-control @error('merk') is-invalid @enderror" id="merk" name="merk" value="{{ @old('merk', $pengadaan->barang->merk) }}">
              @error('merk')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>        
            <div class="mb-3">
              <label for="spesifikasi" class="form-label">Spesifikasi</label>
              <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror" id="spesifikasi" name="spesifikasi" value="{{ @old('spesifikasi', $pengadaan->barang->spesifikasi) }}">
              @error('spesifikasi')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>        
            <div class="mb-3">
              <label for="harga" class="form-label">harga</label>
              <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ @old('harga', number_format($pengadaan->barang->harga, 2, ',', '.')) }}">
              @error('harga')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>        
            
            <div class="mb-3">
              <label for="satuan" class="form-label">Satuan </label>
              <select class="form-select" name="satuan">
                
                
                <option value="unit" {{ @old('satuan', $pengadaan->barang->satuan) == 'unit' ? 'selected' : '' }} selected>unit</option>
                
                <option value="buah" {{ @old('satuan', $pengadaan->barang->satuan) == 'buah' ? 'selected' : '' }} >buah</option>
                <option value="dus" {{ @old('satuan', $pengadaan->barang->satuan) == 'dus' ? 'selected' : '' }} >dus</option>
                <option value="pak" {{ @old('satuan', $pengadaan->barang->satuan) == 'pak' ? 'selected' : '' }} >pak</option>
                <option value="bal" {{ @old('satuan', $pengadaan->barang->satuan) == 'bal' ? 'selected' : '' }} >bal</option>
                
                
              </select>
            </div> 
            <div class="mb-3">
              <label for="jumlah_barang" class="form-label">jumlah barang</label>
              <input type="text" class="form-control @error('jumlah_barang') is-invalid @enderror" id="jumlah_barang" name="jumlah_barang" value="{{ @old('jumlah_barang', $pengadaan->barang->jumlah_barang) }}">
              @error('jumlah_barang')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>        
            {{-- <div class="mb-3">
              <label for="total_biaya" class="form-label">total_biaya</label>
              <input type="text" class="form-control @error('total_biaya') is-invalid @enderror" id="total_biaya" name="total_biaya" value="{{ @old('total_biaya') }}">
              @error('total_biaya')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>         --}}
            <!-- Garis pemisah antara Data Barang dan Data Transaksi Pengadaan -->
            <hr>
            <!-- Data Transaksi Pengadaan -->
            <h4>Data Transaksi Pengadaan</h4>
            <hr>
            <div class="mb-3">
              <label for="tgl_transaksi_pengadaan" class="form-label">Tanggal Transaksi Pengadaan</label>
              <input type="date" class="form-control @error('tgl_transaksi_pengadaan') is-invalid @enderror" id="tgl_transaksi_pengadaan" name="tgl_transaksi_pengadaan" value="{{ @old('tgl_transaksi_pengadaan', $pengadaan->transaksiPengadaan->tgl_transaksi_pengadaan) }}">
              @error('tgl_transaksi_pengadaan')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="mb-3">
              
              {{-- <label for="supplier" class="form-label">supplier</label>
              <select class="form-select" name="supplier_id">
                @foreach ($suppliers as $supplier) 
                  @if(old('supplier_id') == $supplier->id)
                  <option value="{{ $supplier->id }}" {{ old('supplier_id', $pengadaan->transaksiPengadaan->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
                  @else
                  <option value="{{ $supplier->no_telepon }}">{{ $supplier->nama_supplier }}</option>
                  @endif
                @endforeach
              </select>
            </div> --}}

            <div class="mb-3">
              <label for="supplier" class="form-label">supplier</label>
              <select class="form-select" name="supplier_id">
                @foreach ($suppliers as $supplier) 
                  @if(old('supplier_id', $pengadaan->transaksiPengadaan->supplier_id) == $supplier->id)
                  <option value="{{ $supplier->id }}" selected>{{ $supplier->nama_supplier }}</option>
                  @else
                  <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                  @endif
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="jenis_pengadaan" class="form-label">jenis_pengadaan </label>
              <select class="form-select" name="jenis_pengadaan">
                
                
                <option value="pembelian" {{ @old('jenis_pengadaan', $pengadaan->transaksiPengadaan->jenis_pengadaan) == 'pembelian' ? 'selected' : '' }} selected>pembelian</option>
                
                <option value="hibah" {{ @old('jenis_pengadaan', $pengadaan->transaksiPengadaan->jenis_pengadaan) == 'hibah' ? 'selected' : '' }} >hibah</option>
                <option value="sumbangan" {{ @old('jenis_pengadaan', $pengadaan->transaksiPengadaan->jenis_pengadaan) == 'sumbangan' ? 'selected' : '' }}>sumbangan</option>
                <option value="donasi {{ @old('jenis_pengadaan', $pengadaan->transaksiPengadaan->jenis_pengadaan) == 'donasi' ? 'selected' : '' }}">donasi</option>
                <option value="hadiah" {{ @old('jenis_pengadaan', $pengadaan->transaksiPengadaan->jenis_pengadaan) == 'hadiah' ? 'selected' : '' }}>hadiah</option>
                
                
              </select>
            </div> 
            
            <button type="submit" class="btn btn-primary">Edit </button>
        </form>

    </div>
  </div>
</div>
<script>
  const nama_barang = document.querySelector('#nama_barang');
  const slug = document.querySelector('#slug');

  nama_barang.addEventListener('change', function(){
    fetch('/admin/transaksi/pengadaan-barang/checkSlug?nama_barang=' + nama_barang.value)
    .then(response => response.json())
    .then(data => slug.value = data.slug)
  });
</script>
<style>
  .scrolling-container-wrapper {
      /* display: inline-block; Menampilkan elemen seolah-olah dalam satu baris */
      margin: 7px 5px 10px; /* Menambahkan jarak dari semua sisi */
  }

  .scrolling-container {
      max-height: 500px;
      overflow-y: auto;
      background-color: #ffffff;
  }

  /* Modifikasi untuk efek shadow pada semua sisi */
  .scrolling-container {
      box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease;
  }

  .scrolling-container:hover {
      box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
  }
</style>
{{-- script untuk format angka --}}
<script>
  // document.addEventListener("DOMContentLoaded", function () {
  //       const hargaInput = document.getElementById("harga");
        
  //       hargaInput.addEventListener("input", function (event) {
  //           const value = event.target.value;
            
  //           // Hapus semua karakter kecuali angka dan titik desimal
  //           const numericValue = value.replace(/[^\d.]/g, "");
            
  //           // Format sebagai mata uang Rupiah
  //           const formattedValue = new Intl.NumberFormat("id-ID", {
  //               style: "currency",
  //               currency: "IDR",
  //               minimumFractionDigits: 2,
  //               maximumFractionDigits: 2
  //           }).format(numericValue);
            
  //           event.target.value = formattedValue;
  //       });
        
  //       // Ketika formulir dikirim, hapus simbol mata uang sebelum data dikirim ke server
  //       document.querySelector("form").addEventListener("submit", function () {
  //           const numericValue = hargaInput.value.replace(/[^\d.]/g, "");
  //           hargaInput.value = numericValue;
  //       });
  //   });

</script>

@endsection