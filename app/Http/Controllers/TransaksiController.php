<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Perbaikan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::all();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'tanggal_transaksi' => 'required|date',
            'jumlah' => 'required|integer',
            'jenis_transaksi' => 'required',
        ]);

        $transaksi = Transaksi::create($request->all());

        if ($request->jenis_transaksi == 'keluar') {
            Perbaikan::create([
                'transaksi_id' => $transaksi->id,
                'tanggal_perbaikan' => now()->addDays(7), 
                'keterangan_perbaikan' => 'Perbaikan otomatis dari transaksi keluar',
                'status' => 'pending',
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaksi $transaksi)
    {
        return view('transaksi.detail', compact('transaksi'));
    }
}
