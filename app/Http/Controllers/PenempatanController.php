<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Inventaris;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penempatan;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PenempatanController extends Controller
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
        $penempatans = Penempatan::latest()->filter(request(['search', 'barang']))->paginate(3)->withQueryString();

        $index = ($penempatans->currentPage() - 1) * $penempatans->perPage();
        $keyword = $request->query('keyword');
        $query = Penempatan::query(); // Query dasar
        if ($keyword) {
            $query->where('lokasi', 'like', '%' . $keyword . '%');
        }

        return view('admin.penempatan.index', compact('penempatans', 'index', 'query'));
    }
    // pdf
    public function viewPDF()
    {
        $penempatans = Penempatan::all();

        $pdf = PDF::loadView('admin.penempatan.report', array('penempatans' =>  $penempatans))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $penempatans = Penempatan::all();

        $pdf = PDF::loadView('admin.penempatan.report', array('penempatans' =>  $penempatans))
            ->setPaper('a4', 'landscape');

        return $pdf->download('penempatan-details.pdf');
    }
    //end

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.penempatan.create', [
            'penempatans' => Penempatan::all(),
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
            'slug' => 'unique:penempatans',
            'tgl_penempatan'      => 'required',
            'lokasi'      => 'required|max:225',
            'keterangan'      => 'required|max:225',
        ]);

        Penempatan::create($validateData);

        return redirect('/admin/transaksi/penempatan-barang')->with('success', 'Transaksi Penempatan baru berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Penempatan $penempatan)
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
        $penempatan = Penempatan::where('slug', $slug)->latest()->firstOrFail();

        return view('admin.penempatan.edit', [
            'penempatan' => $penempatan,
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
            'inventaris_id'     => 'required',
            'slug'          => 'unique:penempatans',
            'tgl_penempatan'      => 'required',
            'lokasi'        => 'required|max:225',
            'keterangan'    => 'required|max:225',
        ]);

        $penempatan = Penempatan::where('slug', $slug)->firstOrFail();

        $penempatan->update([
            'inventaris_id' => $validateData['inventaris_id'],
        ]);

        $penempatan->update([
            'slug' => $validateData['slug'],
            'tgl_penempatan'      => $validateData['tgl_penempatan'],
            'lokasi'       => $validateData['lokasi'],
            'keterangan'   => $validateData['keterangan'],
        ]);

        // $rules = [
        //     'inventaris_id'     => 'required',
        //     'slug'          => 'unique:penempatans',
        //     'tgl_penempatan'      => 'required',
        //     'lokasi'        => 'required|max:225',
        //     'keterangan'    => 'required|max:225',
        // ];

        // if ($request->slug != $penempatan->slug) {
        //     $rules['slug'] = 'required|unique:penempatans';
        // }

        // $validateData = $request->validate($rules);

        // Penempatan::where('id', $penempatan->id)->update($validateData);

        return redirect('/admin/transaksi/penempatan-barang')->with('success', 'Penempatan baru berhasil diubah!');
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
        $penempatan = Penempatan::where('slug', $slug)->firstOrFail();

        // Hapus data pengadaan_item
        $penempatan->delete();

        // Menghapus barang terkait jika tidak ada pengadaan item lain yang terhubung
        // if (Penempatan::where('inventaris_id', $penempatan->inventaris_id)->count() === 0) {
        //     Barang::where('id', $penempatan->inventaris_id)->delete();
        // }

        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return redirect('/admin/transaksi/penempatan-barang')->with('success', 'Data pengadaan telah dihapus');
    }
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Penempatan::class, 'slug', $request->lokasi);
        return response()->json(['slug' => $slug]);
    }
}
