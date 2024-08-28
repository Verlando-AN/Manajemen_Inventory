<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\jenisBarang;
use Illuminate\Http\Request;

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
            'role' => 'required|in:admin,user',
        ]);

        $user->update($request->only('username', 'email', 'role'));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    public function destroy(User $user)
{
    $user->delete();

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
}
}
