@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Edit Barang</h1>

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="jenis_barang_id" class="form-label">Jenis Barang</label>
            <select name="jenis_barang_id" id="jenis_barang_id" class="form-select" required>
                @foreach($jenisBarangs as $jenisBarang)
                    <option value="{{ $jenisBarang->id }}" {{ $jenisBarang->id == $barang->jenis_barang_id ? 'selected' : '' }}>
                        {{ $jenisBarang->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Pengguna</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $barang->user_id ? 'selected' : '' }}>
                        {{ $user->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="barcode" class="form-label">Barcode</label>
            <input type="text" name="barcode" id="barcode" class="form-control" value="{{ $barang->barcode }}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" value="{{ $barang->stok }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $barang->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="foto_barang" class="form-label">Foto Barang</label>
            <input type="file" name="foto_barang[]" id="foto_barang" class="form-control" multiple>
            <small class="form-text text-muted">Pilih satu atau lebih gambar untuk diunggah.</small>
            @if($barang->fotoBarangs->count())
                <div class="mt-2">
                    <h5>Foto Saat Ini:</h5>
                    <div class="row">
                        @foreach($barang->fotoBarangs as $foto)
                            <div class="col-md-3 mb-2">
                                <img src="{{ asset('storage/' . $foto->path) }}" class="img-thumbnail" alt="Foto Barang">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
