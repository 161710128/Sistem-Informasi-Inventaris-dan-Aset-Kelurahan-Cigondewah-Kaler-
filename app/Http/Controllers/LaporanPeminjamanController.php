<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Peminjaman_barang;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class LaporanPeminjamanController extends Controller
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
        $peminjamans = Peminjaman_barang::latest()->filter(request(['search', 'barang', 'pegawai']))->paginate(3)->withQueryString();

        $index = ($peminjamans->currentPage() - 1) * $peminjamans->perPage();
        $keyword = $request->query('keyword');
        $query = Peminjaman_barang::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_peminjaman', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.laporan-peminjaman.index', compact('peminjamans', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $peminjamans = Peminjaman_barang::all();

        $pdf = PDF::loadView('admin.peminjaman.report', array('peminjamans' =>  $peminjamans))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $peminjamans = Peminjaman_barang::all();

        $pdf = PDF::loadView('admin.peminjaman.report', array('peminjamans' =>  $peminjamans))
            ->setPaper('a4', 'landscape');

        return $pdf->download('peminjaman-details.pdf');
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
