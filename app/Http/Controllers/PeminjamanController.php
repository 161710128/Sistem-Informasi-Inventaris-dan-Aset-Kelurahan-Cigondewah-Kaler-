<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Peminjaman_barang;
use App\Models\Inventaris;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Events\PeminjamanBarangCreated;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (request('barang')) {
        //     $barang = Barang::firstWhere('nama_barang', request('barang'));
        //     $title = ' by ' . $barang->nama_barang;
        // }
        if (request('pegawai')) {
            $pegawai = Pegawai::firstWhere('nama_pegawai', request('pegawai'));
            $title = ' by ' . $pegawai->nama_pegawai;
        }
        $peminjamans = Peminjaman_barang::latest()->filter(request(['search', 'barang', 'pegawai']))->paginate(3)->withQueryString();

        $index = ($peminjamans->currentPage() - 1) * $peminjamans->perPage();
        $keyword = $request->query('keyword');
        $query = Peminjaman_barang::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_peminjaman', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.peminjaman.index', compact('peminjamans', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $peminjamans = Peminjaman_barang::all();

        $pdf = PDF::loadView('admin.peminjaman.report', array('peminjamans' =>  $peminjamans))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $peminjamans = Peminjaman_barang::all();

        $pdf = PDF::loadView('admin.peminjaman.report', array('peminjamans' =>  $peminjamans))
            ->setPaper('a4', 'landscape');

        return $pdf->download('peminjaman-details.pdf');
    }
    //end

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.peminjaman.create', [
            'peminjamans' => Peminjaman_barang::all(),
            'pegawais' => Pegawai::all(),
            'inventory' => Inventaris::all(),
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
        $validateData = $request->validate([
            'inventaris_id' => 'required',
            'pegawai_id' => 'required',
            'slug' => 'unique:peminjaman_barangs',
            'tgl_peminjaman'      => 'required',
            'keterangan'      => 'required|max:225',
        ]);

        $peminjaman = Peminjaman_barang::create($validateData);
        event(new PeminjamanBarangCreated($peminjaman));

        return redirect('/admin/transaksi/peminjaman-barang')->with('success', 'Transaksi Peminjaman baru berhasil ditambah!');
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
        $peminjaman = Peminjaman_barang::where('slug', $slug)->firstOrFail();

        return view('admin.peminjaman.edit', [
            'peminjaman' => $peminjaman,
            'inventory' => Inventaris::all(),
            'pegawais' => Pegawai::all(),
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
        $validateData = $request->validate([
            'inventaris_id' => 'required',
            'pegawai_id' => 'required',
            'tgl_peminjaman'      => 'required',
            'keterangan'      => 'required|max:225',
            'slug' => 'unique:peminjaman_barangs',
        ]);

        $peminjaman = Peminjaman_barang::where('slug', $slug)->firstOrFail();

        $peminjaman->update([
            'inventaris_id' => $validateData['inventaris_id'],
            'pegawai_id' => $validateData['pegawai_id'],
        ]);

        $peminjaman->update([
            'tgl_peminjaman'      => $validateData['tgl_peminjaman'],
            'slug' => $validateData['slug'],
        ]);

        return redirect('/admin/transaksi/peminjaman-barang')->with('success', 'Peminjaman baru berhasil diubah!');
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
        $peminjaman = Peminjaman_barang::where('slug', $slug)->firstOrFail();

        // Hapus data pengadaan_item
        $peminjaman->delete();


        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return redirect('/admin/transaksi/peminjaman-barang')->with('success', 'Data pengadaan telah dihapus');
    }
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Peminjaman_barang::class, 'slug', $request->keterangan);
        return response()->json(['slug' => $slug]);
    }
}
