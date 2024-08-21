<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Perbaikan;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::all();
        return view('reminder.index', compact('reminders'));
    }

    public function create()
    {
        $perbaikans = Perbaikan::where('status', 'pending')->get();
        return view('reminder.create', compact('perbaikans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perbaikan_id' => 'required',
            'tanggal_reminder' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        Reminder::create($request->all());

        // Logika untuk mengirimkan pengingat ke WhatsApp dapat ditambahkan di sini

        return redirect()->route('reminder.index')->with('success', 'Reminder berhasil ditambahkan.');
    }

    public function edit(Reminder $reminder)
    {
        $perbaikans = Perbaikan::where('status', 'pending')->get();
        return view('reminder.edit', compact('reminder', 'perbaikans'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $request->validate([
            'perbaikan_id' => 'required',
            'tanggal_reminder' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        $reminder->update($request->all());
        return redirect()->route('reminder.index')->with('success', 'Reminder berhasil diperbarui.');
    }

    public function destroy(Reminder $reminder)
    {
        $reminder->delete();
        return redirect()->route('reminder.index')->with('success', 'Reminder berhasil dihapus.');
    }
}
