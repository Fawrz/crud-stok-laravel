<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

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

        $namaFileUntukDB = null;

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $namaFileUnik = time() . '_' . $file->getClientOriginalName();
            
            $pathDisimpan = $file->storeAs('public/uploads/barang', $namaFileUnik);

            if ($pathDisimpan) {
                $namaFileUntukDB = $namaFileUnik;
                Log::info('File berhasil diupload: ' . $pathDisimpan); // Logging sukses
            } else {
                // Jika penyimpanan file gagal
                Log::error('Gagal menyimpan file upload.'); // Logging error
                // Redirect kembali dengan pesan error spesifik untuk upload
                return back()->withInput()->with('error_upload', 'Gagal mengupload file foto. Silakan coba lagi.');
            }
        }
        
        $validatedData['foto'] = $namaFileUntukDB;

        Barang::create($validatedData);

        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil ditambahkan!');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'kode'         => 'required|string|max:20|unique:barang,kode,' . $barang->id,
            'nama_barang'  => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'harga_satuan' => 'required|numeric|min:0',
            'jumlah'       => 'required|integer|min:0',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $namaFileUntukDB = $barang->foto;

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $namaFileUnikBaru = time() . '_' . $file->getClientOriginalName();

            $pathDisimpanBaru = $file->storeAs('public/uploads/barang', $namaFileUnikBaru);

            if ($pathDisimpanBaru) {
                if ($barang->foto) {
                    Storage::delete('public/uploads/barang/' . $barang->foto);
                }
                $namaFileUntukDB = $namaFileUnikBaru; // Update nama file untuk DB
                Log::info('File baru berhasil diupload: ' . $pathDisimpanBaru);
            } else {
                // Jika penyimpanan file baru gagal
                Log::error('Gagal menyimpan file upload baru.');
                return back()->withInput()->with('error_upload', 'Gagal mengupload file foto baru. Silakan coba lagi.');
            }
        }
        
        $validatedData['foto'] = $namaFileUntukDB;

        $barang->update($validatedData);

        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto) {
            Storage::delete('public/uploads/barang/' . $barang->foto);
        }
        $barang->delete();
        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil dihapus!');
    }
}
