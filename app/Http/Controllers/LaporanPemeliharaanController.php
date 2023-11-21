<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pemeliharaan;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class LaporanPemeliharaanController extends Controller
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
        $pemeliharaans = Pemeliharaan::latest()->filter(request(['search', 'barang']))->paginate(3)->withQueryString();

        $index = ($pemeliharaans->currentPage() - 1) * $pemeliharaans->perPage();
        $keyword = $request->query('keyword');
        $query = Pemeliharaan::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_pemeliharaan', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.laporan-pemeliharaan.index', compact('pemeliharaans', 'index', 'query'));
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
