<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\FotoBarang; 
use App\Models\User;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }

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
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }

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
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $barang = Barang::create($request->only(
            'jenis_barang_id',
            'nama_barang', 
            'user_id', 
            'barcode', 
            'stok', 
            'deskripsi'
        ));

        if ($request->hasFile('foto_barang')) {
            foreach ($request->file('foto_barang') as $file) {
                $path = $file->store('foto_barang', 'public');
                FotoBarang::create([
                    'barang_id' => $barang->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }

        $jenisBarangs = JenisBarang::all();
        $users = User::all();
        $fotoBarangs = $barang->fotoBarangs; 

        return view('master.barang.edit', compact('barang', 'jenisBarangs', 'users', 'fotoBarangs'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'jenis_barang_id' => 'required|integer',
            'nama_barang' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'barcode' => 'required|string|max:255|unique:barangs,barcode,' . $barang->id,
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_barang_to_delete.*' => 'integer'
        ]);

        $barang->update($request->only('jenis_barang_id', 'nama_barang', 'user_id', 'barcode', 'stok','deskripsi'));

        if ($request->has('foto_barang_to_delete')) {
            foreach ($request->input('foto_barang_to_delete') as $fotoId) {
                $foto = FotoBarang::find($fotoId);
                if ($foto) {
                    Storage::delete($foto->path);
                    $foto->delete();
                }
            }
        }

        if ($request->hasFile('foto_barang')) {
            foreach ($request->file('foto_barang') as $file) {
                $path = $file->store('foto_barang', 'public');
                FotoBarang::create([
                    'barang_id' => $barang->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }
    public function show(Barang $barang)
    {
       
        $jenisBarangs = JenisBarang::all();
        $users = User::all();
        $fotoBarangs = $barang->fotoBarangs; 
    
        return view('master.barang.show', compact('barang', 'jenisBarangs', 'users', 'fotoBarangs'));
    }
    
    public function destroy(Barang $barang)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }

        if ($barang) {
            foreach ($barang->fotoBarangs as $foto) {
                Storage::delete($foto->path);
                $foto->delete();
            }

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
