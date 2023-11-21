<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;

class LaporanSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::latest()->filter(request(['search']))->paginate(3)->withQueryString();
        $barangs = Barang::all();
        $index = ($suppliers->currentPage() - 1) * $suppliers->perPage();
        $keyword = $request->query('keyword');
        $query = Supplier::query(); // Query dasar
        if ($keyword) {
            $query->where('nama_supplier', 'like', '%' . $keyword . '%');
        }

        return view('admin.laporan-supplier.index', compact('suppliers', 'index', 'query'));
    }

    // pdf
    public function viewPDF()
    {
        $suppliers = Supplier::all();

        $pdf = PDF::loadView('admin.laporan-supplier.report', array('suppliers' =>  $suppliers))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
    // end pdf

    //download PDF
    public function downloadPDF()
    {
        $suppliers = Supplier::all();

        $pdf = PDF::loadView('admin.laporan-supplier.report', array('suppliers' =>  $suppliers))
            ->setPaper('a4', 'landscape');

        return $pdf->download('supplier-details.pdf');
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
