@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Edit Pengguna</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

      

        <div class="form-group">
            <label for="password">Password Baru (kosongkan jika tidak diubah)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password baru (minimal 8 karakter)">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" id="photo" name="photo" class="form-control-file">
            @if($user->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" class="img-thumbnail" width="150">
                </div>
            @endif
            @error('photo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
