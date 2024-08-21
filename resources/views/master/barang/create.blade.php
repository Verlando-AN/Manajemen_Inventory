@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Barang</h1>

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="jenis_barang_id" class="form-label">Jenis Barang</label>
            <select name="jenis_barang_id" id="jenis_barang_id" class="form-select" required>
                <option value="" disabled selected>Pilih Jenis Barang</option>
                @foreach($jenisBarangs as $jenisBarang)
                    <option value="{{ $jenisBarang->id }}">{{ $jenisBarang->nama_jenis }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="barcode" class="form-label">Barcode</label>
            <input type="text" name="barcode" id="barcode" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
