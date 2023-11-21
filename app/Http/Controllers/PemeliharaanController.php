<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Inventaris;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pemeliharaan;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PemeliharaanController extends Controller
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
        $pemeliharaans = Pemeliharaan::latest()->filter(request(['search', 'barang']))->paginate(3)->withQueryString();

        $index = ($pemeliharaans->currentPage() - 1) * $pemeliharaans->perPage();
        $keyword = $request->query('keyword');
        $query = Pemeliharaan::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_pemeliharaan', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.pemeliharaan.index', compact('pemeliharaans', 'index', 'query'));
    }
    // pdf
    public function viewPDF()
    {
        $pemeliharaans = Pemeliharaan::all();

        $pdf = PDF::loadView('admin.pemeliharaan.report', array('pemeliharaans' =>  $pemeliharaans))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $pemeliharaans = Pemeliharaan::all();

        $pdf = PDF::loadView('admin.pemeliharaan.report', array('pemeliharaans' =>  $pemeliharaans))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pemeliharaan-details.pdf');
    }
    //end

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pemeliharaan.create', [
            'pemeliharaans' => Pemeliharaan::all(),
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
            'slug' => 'unique:pemeliharaans',
            'tgl_pemeliharaan'      => 'required',
            'biaya_pemeliharaan'      => 'required|max:225',
            'keterangan'      => 'required|max:225',
        ]);

        Pemeliharaan::create($validateData);

        return redirect('/admin/transaksi/pemeliharaan-barang')->with('success', 'Transaksi Pemeliharaan baru berhasil ditambah!');
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
        $pemeliharaan = Pemeliharaan::where('slug', $slug)->latest()->firstOrFail();

        return view('admin.pemeliharaan.edit', [
            'pemeliharaan' => $pemeliharaan,
            'inventory' => Inventaris::all(),
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
            'slug' => 'unique:pemeliharaans',
            'tgl_pemeliharaan'      => 'required',
            'biaya_pemeliharaan'      => 'required|max:225',
            'keterangan'      => 'required|max:225',
        ]);

        $pemeliharaan = Pemeliharaan::where('slug', $slug)->firstOrFail();

        $pemeliharaan->update([
            'inventaris_id' => $validateData['inventaris_id'],
        ]);

        $pemeliharaan->update([
            'slug' => $validateData['slug'],
            'tgl_pemeliharaan'      => $validateData['tgl_pemeliharaan'],
            'biaya_pemeliharaan'       => $validateData['biaya_pemeliharaan'],
            'keterangan'   => $validateData['keterangan'],
        ]);

        return redirect('/admin/transaksi/pemeliharaan-barang')->with('success', 'Pemeliharaan baru berhasil diubah!');
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
        $pemeliharaan = Pemeliharaan::where('slug', $slug)->firstOrFail();

        // Hapus data pengadaan_item
        $pemeliharaan->delete();
        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return redirect('/admin/transaksi/pemeliharaan-barang')->with('success', 'Data pengadaan telah dihapus');
    }
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Pemeliharaan::class, 'slug', $request->keterangan);
        return response()->json(['slug' => $slug]);
    }
}
