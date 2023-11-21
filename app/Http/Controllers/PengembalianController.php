<?php

namespace App\Http\Controllers;

use App\Events\PengembalianDiterima;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman_barang;
use App\Models\Pengembalian;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inventory = Inventaris::all();
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

        return view('admin.pengembalian.index', compact('pengembalians', 'index', 'query'));
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
        return view('admin.pengembalian.create', [
            'pengembalians' => Pengembalian::all(),
            'peminjamans' => Peminjaman_barang::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'peminjaman_id' => 'required',
            'slug' => 'unique:pengembalians',
            // 'tgl_pengembalian'      => 'required',
            'keterangan'      => 'required|max:225',
        ]);

        $pengembalian = Pengembalian::create($validateData);
        event(new PengembalianDiterima($pengembalian->peminjaman_id));

        return redirect('/admin/transaksi/pengembalian-barang')->with('success', 'Transaksi Pengembalian baru berhasil ditambah!');
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
    public function edit($slug)
    {
        $pengembalian = Pengembalian::where('slug', $slug)->firstOrFail();

        return view('admin.pengembalian.edit', [
            'pengembalian' => $pengembalian,
            'peminjamans' => Peminjaman_barang::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $validateData = $request->validate([
            'peminjaman_id' => 'required',
            'slug' => 'unique:pengembalians',
            // 'tgl_pengembalian'      => 'required',
            'keterangan'      => 'required|max:225',
        ]);

        $pengembalian = Pengembalian::where('slug', $slug)->firstOrFail();

        $pengembalian->update([
            'peminjaman_id' => $validateData['peminjaman_id'],
        ]);

        $pengembalian->update([
            // 'tgl_pengembalian'      => $validateData['tgl_pengembalian'],
            'keterangan'   => $validateData['keterangan'],
            'slug' => $validateData['slug'],
        ]);

        return redirect('/admin/transaksi/pengembalian-barang')->with('success', 'Pengembalian baru berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        // Cari pengadaan_item berdasarkan ID
        $pengembalian = Pengembalian::where('slug', $slug)->firstOrFail();

        // Hapus data pengadaan_item
        $pengembalian->delete();


        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return redirect('/admin/transaksi/pengembalian-barang')->with('success', 'Data pengadaan telah dihapus');
    }
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Pengembalian::class, 'slug', $request->keterangan);
        return response()->json(['slug' => $slug]);
    }
}
