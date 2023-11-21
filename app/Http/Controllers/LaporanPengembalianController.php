<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman_barang;
use App\Models\Pengembalian;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class LaporanPengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request('peminjaman')) {
            $peminjaman = Peminjaman_barang::firstWhere('peminjaman_id', request('peminjaman_id'));
            $title = ' by ' . $peminjaman->peminjaman_id;
        }
        $pengembalians = Pengembalian::latest()->filter(request(['search', 'keterangan', 'peminjaman_id']))->paginate(3)->withQueryString();

        $index = ($pengembalians->currentPage() - 1) * $pengembalians->perPage();
        $keyword = $request->query('keyword');
        $query = Pengembalian::query(); // Query dasar
        if ($keyword) {
            $query->where('tgl_pengembalian', 'keterangan', 'like', '%' . $keyword . '%');
        }

        return view('admin.laporan-pengembalian.index', compact('pengembalians', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $pengembalians = Pengembalian::all();

        $pdf = PDF::loadView('admin.pengembalian.report', array('pengembalians' =>  $pengembalians))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $pengembalians = Pengembalian::all();

        $pdf = PDF::loadView('admin.pengembalian.report', array('pengembalians' =>  $pengembalians))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pengembalian-details.pdf');
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
