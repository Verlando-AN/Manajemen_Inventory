<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register.index', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:255'
        ]);

    
        User::create($validatedData);

        return redirect('/login');
    }
}
