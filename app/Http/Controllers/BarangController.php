<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;  
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('jenisBarang', 'user');

        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->input('jenis_barang_id'));
        }

        $barangs = $query->paginate(10);
        $jenisBarangs = JenisBarang::all();

        return view('master.barang.index', compact('barangs', 'jenisBarangs'));
    }

    public function create()
    {
        $jenisBarangs = JenisBarang::all();
        $users = User::all();  

        $barcodeGenerator = new DNS1D();
        $placeholderBarcode = $barcodeGenerator->getBarcodeHTML('SAMPLE123', 'C39');

        return view('master.barang.create', compact('jenisBarangs', 'users', 'placeholderBarcode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang_id' => 'required|integer',
            'nama_barang' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'barcode' => 'required|string|max:255|unique:barangs',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);
    
        Barang::create($request->only('jenis_barang_id', 'nama_barang', 'user_id', 'barcode', 'stok', 'deskripsi'));
    
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $jenisBarangs = JenisBarang::all();
        $users = User::all();  

        return view('master.barang.edit', compact('barang', 'jenisBarangs', 'users'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'jenis_barang_id' => 'required',
            'nama_barang' => 'required',
            'user_id' => 'required', 
            'barcode' => 'required|unique:barangs,barcode,' . $barang->id,
            'stok' => 'required|integer',
        ]);

        $barang->update($request->only('jenis_barang_id', 'nama_barang', 'user_id', 'barcode', 'stok'));
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

    public function showBarcode($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return redirect()->back()->withErrors(['error' => 'Barang tidak ditemukan.']);
        }

        $barcodeGenerator = new DNS1D();
        $barcodeHtml = $barcodeGenerator->getBarcodeHTML($barang->barcode, 'C39');
        $barcodeImage = $barcodeGenerator->getBarcodePNG($barang->barcode, 'C39');

        return view('master.barang.showBarcode', compact('barang', 'barcodeHtml', 'barcodeImage'));
    }
}
