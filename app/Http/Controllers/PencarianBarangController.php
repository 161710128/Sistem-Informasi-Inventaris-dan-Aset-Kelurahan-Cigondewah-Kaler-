<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Kategori;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PencarianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $barangs = Barang::latest()->filter(request(['search']))->paginate(7)->withQueryString();
        $kategoris = Kategori::all();
        $index = ($barangs->currentPage() - 1) * $barangs->perPage();
        $keyword = $request->query('keyword');
        $query = Barang::query(); // Query dasar
        if ($keyword) {
            $query->where('nama_barang', 'like', '%' . $keyword . '%');
        }

        return view('admin.pencarian-barang.index', compact('barangs', 'kategoris', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $barangs = Barang::all();

        $pdf = PDF::loadView('admin.laporan-barang.report', array('barangs' =>  $barangs))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $barangs = Barang::all();

        $pdf = PDF::loadView('admin.laporan-barang.report', array('barangs' =>  $barangs))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-details.pdf');
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
