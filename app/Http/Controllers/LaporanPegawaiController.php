<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class LaporanPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pegawais = Pegawai::latest()->filter(request(['search']))->paginate(3)->withQueryString();
        $barangs = Barang::all();
        $index = ($pegawais->currentPage() - 1) * $pegawais->perPage();
        $keyword = $request->query('keyword');
        $query = Pegawai::query(); // Query dasar
        if ($keyword) {
            $query->where('nama_pegawai', 'like', '%' . $keyword . '%');
        }

        return view('admin.laporan-pegawai.index', compact('pegawais', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $pegawais = Pegawai::all();

        $pdf = PDF::loadView('admin.pegawai.report', array('pegawais' =>  $pegawais))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $pegawais = Pegawai::all();

        $pdf = PDF::loadView('admin.pegawai.report', array('pegawais' =>  $pegawais))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pegawai-details.pdf');
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
