<?php

namespace App\Http\Controllers;


// use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PegawaiController extends Controller
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

        return view('admin.pegawai.index', compact('pegawais', 'index', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pegawai.create', [
            'pegawais' => Pegawai::all()
        ]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_pegawai' => 'required|max:225',
            'slug' => 'unique:pegawais',
            'jabatan'      => 'required'
        ]);

        Pegawai::create($validateData);

        return redirect('/admin/pegawai')->with('success', 'Pegawai baru berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        return view('admin.pegawai.show', compact('pegawai'), [
            'pegawai' => Pegawai::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'), [
            'pegawai' => $pegawai,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $rules = [
            'nama_pegawai' => 'required|max:225',
            'jabatan'      => 'required'
        ];

        if ($request->slug != $pegawai->slug) {
            $rules['slug'] = 'required|unique:pegawais';
        }

        $validateData = $request->validate($rules);

        Pegawai::where('id', $pegawai->id)->update($validateData);

        return redirect('/admin/pegawai')->with('success', 'Pegawai baru berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        Pegawai::destroy($pegawai->id);

        return redirect('/admin/pegawai')->with('success', 'Pegawai telah dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Pegawai::class, 'slug', $request->nama_pegawai);
        return response()->json(['slug' => $slug]);
    }
}
