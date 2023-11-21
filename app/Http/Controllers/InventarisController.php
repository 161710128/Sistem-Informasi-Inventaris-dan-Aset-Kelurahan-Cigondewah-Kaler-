<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Transaksi_pengadaan;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $jumlahInventaris = Inventaris::count();
        $jumlahTransaksi = Transaksi_pengadaan::count();
        $jumlahBarang = Barang::count();

        // Anda juga bisa mengambil jumlah data dari tabel lain
        // Contoh: $jumlahBarang = Barang::count();

        return view('admin.index', compact('jumlahInventaris', 'jumlahTransaksi', 'jumlahBarang'));
    }

    public function dashboard_lurah()
    {
        $jumlahInventaris = Inventaris::count();
        $jumlahTransaksi = Transaksi_pengadaan::count();
        $jumlahBarang = Barang::count();

        // Anda juga bisa mengambil jumlah data dari tabel lain
        // Contoh: $jumlahBarang = Barang::count();

        return view('lurah.index', compact('jumlahInventaris', 'jumlahTransaksi', 'jumlahBarang'));
    }

    public function index(Request $request)
    {
        $inventaris = Inventaris::latest()
            ->filter(request(['search']))
            ->with('barang', 'transaksiPengadaan') // Ambil data terkait
            ->paginate(7)
            ->withQueryString();

        $barangs = Barang::all();
        $pengadaans = Transaksi_pengadaan::all();
        $index = ($inventaris->currentPage() - 1) * $inventaris->perPage();
        $keyword = $request->query('keyword');
        $query = Inventaris::query();

        if ($keyword) {
            // Mencari berdasarkan nama barang
            $query->whereHas('barang', function ($query) use ($keyword) {
                $query->where('nama_barang', 'like', '%' . $keyword . '%');
            });
        }
        // dd($barangs, $pengadaans);
        return view('admin.inventaris.index', compact('inventaris', 'barangs', 'pengadaans', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $inventaris = Inventaris::all();

        $pdf = PDF::loadView('admin.inventaris.report', array('inventaris' =>  $inventaris))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $inventaris = Inventaris::all();

        $pdf = PDF::loadView('admin.inventaris.report', array('inventaris' =>  $inventaris))
            ->setPaper('a4', 'landscape');

        return $pdf->download('inventaris-details.pdf');
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
