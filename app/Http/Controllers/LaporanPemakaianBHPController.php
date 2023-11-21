<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Barang_habis_pakai;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class LaporanPemakaianBHPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request('barang')) {
            $barang = Barang::firstWhere('nama_barang', request('barang'));
            $title = ' by ' . $barang->nama_barang;
        }
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

        return view('admin.laporan-BarangHabisPakai.index', compact('barangHabisPakais', 'index', 'query'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
