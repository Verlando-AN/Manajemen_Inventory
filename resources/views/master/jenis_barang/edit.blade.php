@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Edit Jenis Barang</h1>

    <form action="{{ route('jenis_barang.update', $jenisBarang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_jenis" class="form-label">Nama Jenis</label>
            <input type="text" name="nama_jenis" id="nama_jenis" class="form-control" value="{{ $jenisBarang->nama_jenis }}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" value="{{ $jenisBarang->stok }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
