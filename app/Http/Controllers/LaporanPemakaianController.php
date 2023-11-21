<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Pemakaian;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class LaporanPemakaianController extends Controller
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
        $pemakaians = Pemakaian::latest()->filter(request(['search', 'barang', 'pegawai']))->paginate(3)->withQueryString();

        $index = ($pemakaians->currentPage() - 1) * $pemakaians->perPage();
        $keyword = $request->query('keyword');
        $query = Pemakaian::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_pemakaian', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.laporan-pemakaian.index', compact('pemakaians', 'index', 'query'));
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
