<?php

namespace App\Http\Controllers;

use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kategoris.index', [
            'kategoris' => Kategori::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kategoris.create', [
            'kategoris' => Kategori::all()
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
            'nama_kategori' => 'required|max:225',
            'slug' => 'unique:kategoris'
        ]);

        Kategori::create($validateData);

        return redirect('/admin/kategoribarang')->with('success', 'Kategori Barang baru berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        return view('admin.kategoris.show', compact('kategori'), [
            'kategori' => $kategori
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        return view('admin.kategoris.edit', compact('kategori'), [
            'kategori' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $rules = [
            'nama_kategori' => 'required|max:225',
        ];

        if ($request->slug != $kategori->slug) {
            $rules['slug'] = 'required|unique:kategoris';
        }

        $validateData = $request->validate($rules);

        Kategori::where('id', $kategori->id)->update($validateData);

        return redirect('/admin/kategoribarang')->with('success', 'kategori baru berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        Kategori::destroy($kategori->id);

        return redirect('/admin/kategoribarang')->with('success', 'Kategori telah dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Kategori::class, 'slug', $request->nama_kategori);
        return response()->json(['slug' => $slug]);
    }
}
