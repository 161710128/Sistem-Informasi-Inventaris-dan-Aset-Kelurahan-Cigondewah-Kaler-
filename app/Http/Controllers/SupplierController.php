<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.supplier.index', [
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier.create', [
            'suppliers' => Supplier::all()
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
            'nama_supplier' => 'required|max:225',
            'slug' => 'unique:supplier',
            'alamat'      => 'required',
            'no_telepon'      => 'required'
        ]);

        Supplier::create($validateData);

        return redirect('/admin/supplier')->with('success', 'Pegawai baru berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('admin.supplier.show', compact('supplier'), [
            'supplier' => Supplier::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'), [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'nama_supplier' => 'required|max:225',
            'alamat'      => 'required|max:225',
            'no_telepon'      => 'required',
        ];

        if ($request->slug != $supplier->slug) {
            $rules['slug'] = 'required|unique:suppliers';
        }

        $validateData = $request->validate($rules);

        Supplier::where('id', $supplier->id)->update($validateData);

        return redirect('/admin/supplier')->with('success', 'supplier baru berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        Supplier::destroy($supplier->id);

        return redirect('/admin/supplier')->with('success', 'Supplier telah dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Supplier::class, 'slug', $request->nama_supplier);
        return response()->json(['slug' => $slug]);
    }
}
