@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Jenis Barang</h1>

    <form action="{{ route('jenis_barang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_jenis" class="form-label">Nama Jenis</label>
            <input type="text" name="nama_jenis" id="nama_jenis" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
