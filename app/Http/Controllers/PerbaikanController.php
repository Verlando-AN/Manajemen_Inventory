<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\FotoKerusakan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PerbaikanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query();

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->input('tanggal'));
        }

        if ($request->filled('bulan')) {
            $bulan = $request->input('bulan');
            $tahun = $request->filled('tahun') ? $request->input('tahun') : date('Y');

            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->input('tahun'));
        }

        $laporans = $query->get();

        return view('perbaikan.index', compact('laporans'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $laporan->update([
            'status' => $request->status,
            'estimasi_selesai' => $request->status === 'disetujui' ? Carbon::now()->addDays(7) : null,
        ]);

        return redirect()->route('perbaikan.index')->with('success', 'Status laporan berhasil diperbarui.');
    }
}
