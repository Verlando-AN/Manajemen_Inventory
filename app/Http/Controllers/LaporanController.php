<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\FotoKerusakan;
use Illuminate\Http\Request;
use Twilio\Rest\Client; 

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::all();
        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|unique:laporans',
            'nama_laptop' => 'required',
            'jenis_kerusakan' => 'required',
            'deskripsi' => 'nullable',
            'foto_kerusakan.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $laporan = Laporan::create($request->only('barcode', 'nama_laptop', 'jenis_kerusakan', 'deskripsi'));

        if ($request->hasFile('foto_kerusakan')) {
            foreach ($request->file('foto_kerusakan') as $file) {
                $path = $file->store('foto_kerusakan', 'public');
                FotoKerusakan::create([
                    'laporan_id' => $laporan->id,
                    'path' => $path
                ]);
            }
        }

        // Kirim notifikasi WhatsApp
        $this->sendWhatsAppNotification($laporan);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    private function sendWhatsAppNotification($laporan)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');
        $adminNumber = env('ADMIN_WHATSAPP_NUMBER');

        $client = new Client($sid, $token);

        $message = "Laporan baru telah dibuat:\n\n"
                    . "Barcode: {$laporan->barcode}\n"
                    . "Nama Laptop: {$laporan->nama_laptop}\n"
                    . "Jenis Kerusakan: {$laporan->jenis_kerusakan}\n"
                    . "Deskripsi: {$laporan->deskripsi}";

        $client->messages->create(
            "whatsapp:{$adminNumber}",
            [
                'from' => "whatsapp:{$twilioNumber}",
                'body' => $message
            ]
        );
    }

    public function edit(Laporan $laporan)
    {
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'barcode' => 'required|unique:laporans,barcode,' . $laporan->id,
            'nama_laptop' => 'required',
            'jenis_kerusakan' => 'required',
            'deskripsi' => 'nullable',
            'foto_kerusakan.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $laporan->update($request->only('barcode', 'nama_laptop', 'jenis_kerusakan', 'deskripsi'));

        if ($request->hasFile('foto_kerusakan')) {
            foreach ($request->file('foto_kerusakan') as $file) {
                $path = $file->store('foto_kerusakan', 'public');
                FotoKerusakan::create([
                    'laporan_id' => $laporan->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->fotoKerusakans()->delete(); 
        $laporan->delete(); 
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function show(Laporan $laporan)
    {
        return view('laporan.show', compact('laporan'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $laporan->update(['status' => $request->status]);
        
        return redirect()->route('laporan.index')->with('success', 'Status laporan berhasil diperbarui.');
    }
}
