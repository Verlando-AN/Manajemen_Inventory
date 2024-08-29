@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Tambah Barang</h1>

    <div class="card shadow-lg border-light">
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="jenis_barang_id" class="form-label">Jenis Barang</label>
                        <select name="jenis_barang_id" id="jenis_barang_id" class="form-select form-select-lg" required>
                            <option value="" disabled selected>Pilih Jenis Barang</option>
                            @foreach($jenisBarangs as $jenisBarang)
                                <option value="{{ $jenisBarang->id }}">{{ $jenisBarang->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control form-control-lg" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="user_id" class="form-label">Pengguna</label>
                        <select name="user_id" id="user_id" class="form-select form-select-lg" required>
                            <option value="" disabled selected>Pilih Pengguna</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" name="barcode" id="barcode" class="form-control form-control-lg" required>
                        <small class="form-text text-muted">
                            Barcode:
                            <br>
                            {!! $placeholderBarcode !!}
                        </small>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control form-control-lg" required>
                    </div>

                    <div class="col-md-6">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control form-control-lg" rows="4" placeholder="Masukkan deskripsi barang"></textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="foto_barang" class="form-label">Foto Barang</label>
                        <input type="file" name="foto_barang[]" id="foto_barang" class="form-control form-control-lg" multiple>
                        <small class="form-text text-muted">Pilih satu atau lebih gambar untuk diunggah.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-lg">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
