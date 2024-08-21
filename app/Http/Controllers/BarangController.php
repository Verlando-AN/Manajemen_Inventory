<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('master.barang.index', compact('barangs'));
    }

    public function create()
    {
        $jenisBarangs = JenisBarang::all();
        return view('master.barang.create', compact('jenisBarangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang_id' => 'required',
            'nama_barang' => 'required',
            'barcode' => 'required|unique:barangs',
            'stok' => 'required|integer',
        ]);

        Barang::create($request->only('jenis_barang_id', 'nama_barang', 'barcode', 'stok'));
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $jenisBarangs = JenisBarang::all();
        return view('master.barang.edit', compact('barang', 'jenisBarangs'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'jenis_barang_id' => 'required',
            'nama_barang' => 'required',
            'barcode' => 'required|unique:barangs,barcode,' . $barang->id,
            'stok' => 'required|integer',
        ]);

        $barang->update($request->only('jenis_barang_id', 'nama_barang', 'barcode', 'stok'));
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang) {
            $barang->delete();
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
        } else {
            return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan.');
        }
    }
}
