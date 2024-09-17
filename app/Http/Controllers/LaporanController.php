<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Barang;
use App\Models\User;
use App\Models\Status;
use App\Models\FotoKerusakan;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke bagian ini.');
        }
    
        $query = Laporan::query();

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

        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required',
            'nama_laptop' => 'required',
            'jenis_kerusakan' => 'required',
            'deskripsi' => 'nullable',
            'foto_kerusakan.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $barang = Barang::where('barcode', $request->barcode)->first();
    
        if (!$barang) {
            return redirect()->back()->withErrors(['error' => 'Barang dengan barcode tersebut tidak ditemukan.']);
        }
    
        // Buat laporan baru
        $laporan = Laporan::create([
            'barcode' => $request->barcode,
            'nama_laptop' => $barang->nama_barang,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi' => $request->deskripsi,
            'status_id' => 1, 
            'user_id' => Auth::id(), 
        ]);
    
        // Menyimpan foto kerusakan jika ada
        if ($request->hasFile('foto_kerusakan')) {
            foreach ($request->file('foto_kerusakan') as $file) {
                $path = $file->store('foto_kerusakan', 'public');
                FotoKerusakan::create([
                    'laporan_id' => $laporan->id,
                    'path' => $path
                ]);
            }
        }
    
        // Kirim notifikasi WhatsApp melalui Fonnte API
        $this->sendWhatsAppNotification($laporan);
    
        // Redirect setelah berhasil
        return redirect()->route('laporan.create')->with('success', 'Laporan berhasil ditambahkan.');
    }
    
    private function sendWhatsAppNotification($laporan)
    {
        $token = "@Jx9ATNE9hbJFEAM!TL5";
        $admin = User::where('role', 'admin')->first();
        $target = $admin->wa;
    
        $userName = $laporan->user ? $laporan->user->username : 'Unknown';

        $message = "Laporan baru telah dibuat:\n\n"
                    . "Dilaporkan oleh: {$userName}\n"
                    . "Nama barang: {$laporan->nama_laptop}\n"
                    . "Jenis Kerusakan: {$laporan->jenis_kerusakan}\n"
                    . "Deskripsi: {$laporan->deskripsi}\n"
                    . "Barcode: {$laporan->barcode}";
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query([
                'target' => $target,
                'message' => $message,
            ]),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token",
            ),
        ));
        
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error("Curl error: " . $error_msg);
        }

        curl_close($curl);
        
        if (isset($error_msg)) {
            Log::error("WhatsApp Notification Error: " . $error_msg);
        } else {
            Log::info("WhatsApp Notification Response: " . $response);
        }
    }
    
    public function edit(Laporan $laporan)
    {
        $statuss = Status::all();
        return view('laporan.edit', compact('laporan', 'statuss'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        if (Auth::user()->role !== 'admin' && $laporan->user_id !== Auth::id()) {
            return redirect()->route('laporan.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk memperbarui laporan ini.']);
        }

        $request->validate([
            'status_id' => 'required|integer|exists:statuss,id',
            'estimasi_selesai' => 'nullable|date',
        ]);

        $data = $request->only('status_id', 'estimasi_selesai');

        if ($data['estimasi_selesai']) {
            $data['estimasi_selesai'] = Carbon::parse($data['estimasi_selesai'])->format('Y-m-d');
        }

        $laporan->update($data);

        if ($request->hasFile('foto_kerusakan')) {
            foreach ($request->file('foto_kerusakan') as $file) {
                $path = $file->store('foto_kerusakan', 'public');
                FotoKerusakan::create([
                    'laporan_id' => $laporan->id,
                    'path' => $path
                ]);
            }
        }
        $this->sendWhatsApp($laporan);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        if (Auth::user()->role !== 'admin' && $laporan->user_id !== Auth::id()) {
            return redirect()->route('laporan.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk menghapus laporan ini.']);
        }

        $laporan->fotoKerusakans()->delete();
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function show(Laporan $laporan)
    {
        $fotoKerusakans = $laporan->fotoKerusakans;
        return view('laporan.show', compact('laporan', 'fotoKerusakans'));
    }

    public function showHome()
    {
        $jumlahLaporan = Laporan::count();
        $laporanTerbaru = Laporan::latest()->first();
        $aktivitasTerakhir = Laporan::latest()->first();

        // Mengirim data ke view 'home'
        return view('home', compact('jumlahLaporan', 'laporanTerbaru', 'aktivitasTerakhir'));
    }
    private function sendWhatsApp($laporan)
    {
        $token = "@Jx9ATNE9hbJFEAM!TL5";
        $user = $laporan->user;
        $target = $user->wa;
    
        $userName = $laporan->user ? $laporan->user->username : 'Unknown';
        $status = $laporan->status ? $laporan->status->status : 'Unknown';

        $message = "Status Laporan Kamu Diperbarui: {$status}\n\n"
                    . "Nama barang: {$laporan->nama_laptop}\n"
                    . "Jenis Kerusakan: {$laporan->jenis_kerusakan}\n"
                    . "Deskripsi: {$laporan->deskripsi}\n"
                    . "Barcode: {$laporan->barcode}";
    
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query([
                'target' => $target,
                'message' => $message,
            ]),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token",
            ),
        ));
        
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error("Curl error: " . $error_msg);
        }

        curl_close($curl);
        
        if (isset($error_msg)) {
            Log::error("WhatsApp Notification Error: " . $error_msg);
        } else {
            Log::info("WhatsApp Notification Response: " . $response);
        }
    }
}
