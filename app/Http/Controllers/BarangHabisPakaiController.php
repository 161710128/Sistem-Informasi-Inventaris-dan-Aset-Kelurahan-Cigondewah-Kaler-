<?php

namespace App\Http\Controllers;

use App\Events\EntriPemakaianBarangHabis;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Barang_habis_pakai;
use App\Models\Inventaris;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class BarangHabisPakaiController extends Controller
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
        $barangHabisPakais = Barang_habis_pakai::latest()->filter(request(['search', 'barang', 'pegawai']))->paginate(3)->withQueryString();

        $index = ($barangHabisPakais->currentPage() - 1) * $barangHabisPakais->perPage();
        $keyword = $request->query('keyword');
        $query = Barang_habis_pakai::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_pemakaian_barang_habis_pakai', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.pemakaianBHP.index', compact('barangHabisPakais', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $barangHabisPakais = Barang_habis_pakai::all();

        $pdf = PDF::loadView('admin.pemakaianBHP.report', array('barangHabisPakais' =>  $barangHabisPakais))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $barangHabisPakais = Barang_habis_pakai::all();

        $pdf = PDF::loadView('admin.pemakaianBHP.report', array('barangHabisPakais' =>  $barangHabisPakais))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pemakaianBHP-details.pdf');
    }
    //end

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pemakaianBHP.create', [
            'barangHabisPakais' => Barang_habis_pakai::all(),
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
            'slug' => 'unique:barang_habis_pakais',
            'tgl_pemakaian_barang_habis_pakai'      => 'required',
            'keterangan'      => 'required|max:225',
        ]);

        $pemakaian = Barang_habis_pakai::create($validateData);
        event(new EntriPemakaianBarangHabis($pemakaian));

        return redirect('/admin/transaksi/pemakaian-barangHabisPakai')->with('success', 'Transaksi Pemakaian baru berhasil ditambah!');
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
        $barangHabisPakai = Barang_habis_pakai::where('slug', $slug)->firstOrFail();

        return view('admin.pemakaianBHP.edit', [
            'barangHabisPakai' => $barangHabisPakai,
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
            'slug' => 'unique:barang_habis_pakais',
            'tgl_pemakaian_barang_habis_pakai'      => 'required',
            'keterangan'      => 'required|max:225',
        ]);

        $barangHabisPakai = Barang_habis_pakai::where('slug', $slug)->firstOrFail();

        $barangHabisPakai->update([
            'inventaris_id' => $validateData['inventaris_id'],
            'pegawai_id' => $validateData['pegawai_id'],
        ]);

        $barangHabisPakai->update([
            'tgl_pemakaian_barang_habis_pakai'      => $validateData['tgl_pemakaian_barang_habis_pakai'],
            'keterangan'   => $validateData['keterangan'],
            'slug' => $validateData['slug'],
        ]);

        return redirect('/admin/transaksi/pemakaian-barangHabisPakai')->with('success', 'pemakaian baru berhasil diubah!');
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
        $barangHabisPakai = Barang_habis_pakai::where('slug', $slug)->firstOrFail();

        // Hapus data pengadaan_item
        $barangHabisPakai->delete();


        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return redirect('/admin/transaksi/pemakaian-barangHabisPakai')->with('success', 'Data pengadaan telah dihapus');
    }
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Barang_habis_pakai::class, 'slug', $request->keterangan);
        return response()->json(['slug' => $slug]);
    }
}
