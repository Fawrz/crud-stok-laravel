<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::latest()->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode'         => 'required|string|max:20|unique:barang,kode',
            'nama_barang'  => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'harga_satuan' => 'required|numeric|min:0',
            'jumlah'       => 'required|integer|min:0',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $namaFileUnik = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads/barang', $namaFileUnik);
            $validatedData['foto'] = $namaFileUnik;
        } else {
            $validatedData['foto'] = null;
        }

        Barang::create($validatedData);

        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
