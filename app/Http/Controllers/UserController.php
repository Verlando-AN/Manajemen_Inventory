<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); 
        $barangs = Barang::with('jenisBarang', 'user')->get();

        return view('users.index', compact('barangs', 'users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'wa' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
            $user->photo = $photoPath; 
        }
    
        $userData = $request->only('username', 'email', 'wa');
    
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->input('password'));
        }
    
        $user->update($userData);
    
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->cannot('delete', $user)) {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki izin untuk menghapus pengguna ini.');
        }

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
