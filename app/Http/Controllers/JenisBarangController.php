<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }

        $jenisBarangs = JenisBarang::all();
        return view('master.jenis_barang.index', compact('jenisBarangs'));
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }
        return view('master.jenis_barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        JenisBarang::create($request->all());
        return redirect()->route('jenis_barang.index')->with('success', 'Jenis barang berhasil ditambahkan.');
    }

    public function edit(JenisBarang $jenisBarang)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }
        return view('master.jenis_barang.edit', compact('jenisBarang'));
    }

    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        $jenisBarang->update($request->all());
        return redirect()->route('jenis_barang.index')->with('success', 'Jenis barang berhasil diperbarui.');
    }

    public function destroy(JenisBarang $jenisBarang)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }

        $jenisBarang->delete();
        return redirect()->route('jenis_barang.index')->with('success', 'Jenis barang berhasil dihapus.');
    }
}
