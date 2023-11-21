<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Transaksi_pengadaan;
use App\Models\Pengadaan_item;
use App\Models\Inventaris;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class PengadaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pengadaans = Pengadaan_item::latest()->paginate(7)->withQueryString();
        $index = ($pengadaans->currentPage() - 1) * $pengadaans->perPage();

        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $transaksis = Transaksi_pengadaan::all();
        $kategoris = Kategori::all();


        return view('admin.pengadaanbarang.index', compact('pengadaans', 'suppliers', 'barangs', 'transaksis', 'kategoris', 'index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pengadaanbarang.create', [
            'pengadaans' => Pengadaan_item::all(),
            'barangs' => Barang::all(),
            'transaksis' => Transaksi_pengadaan::all(),
            'suppliers' => Supplier::all(),
            'kategoris' => Kategori::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validateData = $request->validate([
            'nama_barang' => 'required|max:225',
            'kategori_barang_id' => 'required',
            'merk' => 'required|max:225',
            'slug' => 'required',
            'spesifikasi' => 'required|max:225',
            'harga' => 'required',
            'satuan' => 'required',
            'jumlah_barang' => 'required|integer',
        ]);

        // Simpan data transaksi_pengadaan
        $transaksiPengadaan = new Transaksi_pengadaan;
        $transaksiPengadaan->tgl_transaksi_pengadaan = $request->tgl_transaksi_pengadaan; // Tanggal sekarang
        $transaksiPengadaan->supplier_id = $request->supplier_id;
        $transaksiPengadaan->jenis_pengadaan = $request->jenis_pengadaan;
        $transaksiPengadaan->slug = $validateData['slug'];
        // ...isi kolom lainnya...
        $transaksiPengadaan->save();

        $kode_label = 1; // Inisialisasi kode_label
        $existingSlugs = Barang::where('slug', 'like', Str::slug($validateData['nama_barang']) . '%')->pluck('slug');
        $totalBiayaPerBarang = $validateData['harga'] * $validateData['jumlah_barang']; // Total biaya per barang

        for ($i = 1; $i <= $validateData['jumlah_barang']; $i++) {
            $proposedSlug = $i > 1 ? Str::slug($validateData['nama_barang'] . '-' . $i) : Str::slug($validateData['nama_barang']);

            while (in_array($proposedSlug, $existingSlugs->toArray())) {
                $i++;
                $proposedSlug = Str::slug($validateData['nama_barang'] . '-' . $i);
            }

            // Simpan data barang
            $barang = new Barang;
            $barang->nama_barang = $validateData['nama_barang'];
            $barang->kategori_barang_id = $validateData['kategori_barang_id'];
            $barang->slug = Str::slug($validateData['nama_barang']) . '-' . $i; // Membuat slug unik
            $barang->merk = $validateData['merk'];
            $barang->spesifikasi = $validateData['spesifikasi'];
            $barang->harga = $validateData['harga'];
            $barang->satuan = $validateData['satuan'];
            $barang->jumlah_barang = 1; // Set jumlah_barang ke 1 untuk masing-masing barang
            $barang->total_biaya = $totalBiayaPerBarang;  // Total biaya untuk satu barang
            $barang->kode_label = $kode_label; // Set kode_label
            // ...isi kolom lainnya...
            $barang->save();

            // Simpan data Pengadaan_item
            $transaksiPengadaanItem = new Pengadaan_item;
            $transaksiPengadaanItem->barang_id = $barang->id;
            $transaksiPengadaanItem->transaksi_pengadaan_id = $transaksiPengadaan->id;
            $transaksiPengadaanItem->slug = $barang->slug;
            // ...isi kolom lainnya...
            $transaksiPengadaanItem->save();

            $kode_label++; // Tambahkan kode_label untuk barang berikutnya

            // Simpan data Inventaris terkait untuk setiap barang
            $inventaris = new Inventaris;
            $inventaris->barang_id = $barang->id;
            $inventaris->transaksi_pengadaan_id = $transaksiPengadaan->id;
            $inventaris->kode_inventaris = 'INV-' . sprintf('%04d', $i); // Misalnya, format kode inventaris
            $inventaris->slug = $barang->kode_label;
            $inventaris->kondisi = 'baik'; // Misalnya
            $inventaris->status = 'tersedia'; // Misalnya
            // ...isi kolom lainnya...
            $inventaris->save();
        }

        return redirect('/admin/transaksi/pengadaan-barang')->with('success', 'Pegawai baru berhasil ditambah!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $pengadaan = Pengadaan_item::where('slug', $slug)->firstOrFail();

        return view('admin.pengadaanbarang.edit', [
            'pengadaan' => $pengadaan,
            'barangs' => Barang::all(),
            'transaksis' => Transaksi_pengadaan::all(),
            'suppliers' => Supplier::all(),
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        // Validasi input
        $validateData = $request->validate([
            'nama_barang' => 'required|max:225',
            'kategori_barang_id' => 'required',
            'merk' => 'required|max:225',
            'slug' => 'required',
            'spesifikasi' => 'required|max:225',
            'harga' => 'required',
            'satuan' => 'required',
            'jumlah_barang' => 'required|integer',
        ]);

        // Hitung total_biaya
        $totalBiaya = $validateData['harga'] * $validateData['jumlah_barang'];

        // Cari pengadaan berdasarkan ID
        // $pengadaan = Pengadaan_item::findOrFail($id);
        $pengadaan = Pengadaan_item::where('slug', $slug)->firstOrFail();


        // Update data barang melalui relasi
        $pengadaan->barang->update([
            'nama_barang' => $validateData['nama_barang'],
            'kategori_barang_id' => $validateData['kategori_barang_id'],
            'slug' => $validateData['slug'],
            'merk' => $validateData['merk'],
            'spesifikasi' => $validateData['spesifikasi'],
            'harga' => $validateData['harga'],
            'satuan' => $validateData['satuan'],
            'jumlah_barang' => $validateData['jumlah_barang'],
            'total_biaya' => $totalBiaya,
            // ...update kolom lainnya...
        ]);

        // Update data transaksi_pengadaan melalui relasi
        $pengadaan->transaksiPengadaan->update([
            'tgl_transaksi_pengadaan' => $request->tgl_transaksi_pengadaan,
            'supplier_id' => $request->supplier_id,
            'jenis_pengadaan' => $request->jenis_pengadaan,
            'slug' => $request->slug,

            // ...update kolom lainnya...
        ]);

        $pengadaan->update([
            'slug' => $validateData['slug'],
        ]);

        // Redirect kembali ke halaman index atau halaman detail
        return redirect('/admin/transaksi/pengadaan-barang')->with('success', 'Data pengadaan telah diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        // Cari pengadaan_item berdasarkan ID
        $pengadaanItem = Pengadaan_item::where('slug', $slug)->firstOrFail();

        // Hapus data pengadaan_item
        $pengadaanItem->delete();

        // Menghapus barang terkait jika tidak ada pengadaan item lain yang terhubung
        if (Pengadaan_item::where('barang_id', $pengadaanItem->barang_id)->count() === 0) {
            Barang::where('id', $pengadaanItem->barang_id)->delete();
            Inventaris::where('barang_id', $pengadaanItem->barang_id)->delete();
        }

        // Menghapus transaksi pengadaan terkait jika tidak ada pengadaan item lain yang terhubung
        if (Pengadaan_item::where('transaksi_pengadaan_id', $pengadaanItem->transaksi_pengadaan_id)->count() === 0) {
            Transaksi_pengadaan::where('id', $pengadaanItem->transaksi_pengadaan_id)->delete();
            Inventaris::where('transaksi_pengadaan_id', $pengadaanItem->transaksi_pengadaan_id)->delete();
        }

        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return redirect('/admin/transaksi/pengadaan-barang')->with('success', 'Data pengadaan telah dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Barang::class, 'slug', $request->nama_barang);
        return response()->json(['slug' => $slug]);
    }
}
