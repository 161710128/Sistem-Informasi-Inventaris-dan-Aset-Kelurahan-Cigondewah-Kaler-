<?php

namespace App\Http\Controllers;

use App\Events\EntriPemakaian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Pegawai;
use App\Models\Pemakaian;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PemakaianController extends Controller
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
        $pemakaians = Pemakaian::latest()->filter(request(['search', 'barang', 'pegawai']))->paginate(3)->withQueryString();


        $index = ($pemakaians->currentPage() - 1) * $pemakaians->perPage();
        $keyword = $request->query('keyword');
        $query = Pemakaian::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_pemakaian', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.pemakaian.index', compact('pemakaians', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $pemakaians = Pemakaian::all();

        $pdf = PDF::loadView('admin.pemakaian.report', array('pemakaians' =>  $pemakaians))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $pemakaians = Pemakaian::all();

        $pdf = PDF::loadView('admin.pemakaian.report', array('pemakaians' =>  $pemakaians))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pemakaian-details.pdf');
    }
    //end

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pemakaian.create', [
            'pemakaians' => Pemakaian::all(),
            'inventory' => Inventaris::all(),
            'pegawais' => Pegawai::all(),
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
            'slug' => 'unique:pemakaians',
            'tgl_pemakaian'      => 'required',
            'keterangan'      => 'required|max:225',
        ]);

        $pemakaian = Pemakaian::create($validateData);
        event(new EntriPemakaian($pemakaian));

        return redirect('/admin/transaksi/pemakaian-barang')->with('success', 'Transaksi Pemakaian baru berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function show(Pemakaian $pemakaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $pemakaian = Pemakaian::where('slug', $slug)->firstOrFail();

        return view('admin.pemakaian.edit', [
            'pemakaian' => $pemakaian,
            'inventory' => Inventaris::all(),
            'pegawais' => Pegawai::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $validateData = $request->validate([
            'inventaris_id' => 'required',
            'pegawai_id' => 'required',
            'slug' => 'unique:pemakaians',
            'tgl_pemakaian'      => 'required',
            'keterangan'      => 'required|max:225',
        ]);

        $pemakaian = Pemakaian::where('slug', $slug)->firstOrFail();

        $pemakaian->update([
            'inventaris_id' => $validateData['inventaris_id'],
            'pegawai_id' => $validateData['pegawai_id'],
        ]);

        $pemakaian->update([
            'tgl_pemakaian'      => $validateData['tgl_pemakaian'],
            'keterangan'   => $validateData['keterangan'],
            'slug' => $validateData['slug'],
        ]);

        return redirect('/admin/transaksi/pemakaian-barang')->with('success', 'pemakaian baru berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        // Cari pengadaan_item berdasarkan ID
        $pemakaian = Pemakaian::where('slug', $slug)->firstOrFail();

        // Hapus data pengadaan_item
        $pemakaian->delete();


        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return redirect('/admin/transaksi/pemakaian-barang')->with('success', 'Data pengadaan telah dihapus');
    }
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Pemakaian::class, 'slug', $request->keterangan);
        return response()->json(['slug' => $slug]);
    }
}
