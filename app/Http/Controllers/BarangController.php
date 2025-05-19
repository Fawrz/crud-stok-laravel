<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk logging

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

        $namaFileUntukDB = null; // Inisialisasi nama file untuk DB

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $namaFileUnik = time() . '_' . $file->getClientOriginalName();
            
            // Coba simpan file dan cek hasilnya
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
        
        $validatedData['foto'] = $namaFileUntukDB; // Gunakan variabel yang sudah dicek

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

        $namaFileUntukDB = $barang->foto; // Defaultnya adalah foto lama

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $namaFileUnikBaru = time() . '_' . $file->getClientOriginalName();

            // Coba simpan file baru dan cek hasilnya
            $pathDisimpanBaru = $file->storeAs('public/uploads/barang', $namaFileUnikBaru);

            if ($pathDisimpanBaru) {
                // Jika file baru berhasil disimpan, hapus file lama (jika ada)
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
        // Jika tidak ada file baru yang diupload, $namaFileUntukDB tetap berisi nama foto lama.
        // Jika ada file baru dan berhasil diupload, $namaFileUntukDB sudah diupdate.
        
        $validatedData['foto'] = $namaFileUntukDB; // Masukkan nama file foto (lama atau baru) ke data yang akan diupdate

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
