<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use App\Models\Transaksi_pengadaan;
use App\Models\Pengadaan_item;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class Transaksi_pengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pengadaans = Transaksi_pengadaan::latest()->filter(request(['search', 'supplier']))->paginate(7)->withQueryString();
        $suppliers = Supplier::all();

        $index = ($pengadaans->currentPage() - 1) * $pengadaans->perPage();
        $keyword = $request->query('keyword');
        $query = Transaksi_pengadaan::query(); // Query dasar
        if ($keyword) {
            $query->where('slug', 'like', '%' . $keyword . '%')
                ->orWhere('slug', 'like', '%' . $keyword . '%')
                ->orWhere('jenis_pengadaan', 'like', '%' . $keyword . '%');
        }

        return view('admin.laporan-pengadaan.index', compact('pengadaans', 'suppliers', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $pengadaans = Transaksi_pengadaan::all();

        $pdf = PDF::loadView('admin.laporan-pengadaan.report', array('pengadaans' =>  $pengadaans))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $pengadaans = Transaksi_pengadaan::all();

        $pdf = PDF::loadView('admin.laporan-pengadaan.report', array('pengadaans' =>  $pengadaans))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengadaan-details.pdf');
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
