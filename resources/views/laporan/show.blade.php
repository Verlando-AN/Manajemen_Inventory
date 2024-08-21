@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Detail Laporan Kerusakan</h1>

    <div class="mb-3">
        <strong>Barcode:</strong> {{ $laporan->barcode }}
    </div>
    <div class="mb-3">
        <strong>Nama Laptop:</strong> {{ $laporan->nama_laptop }}
    </div>
    <div class="mb-3">
        <strong>Jenis Kerusakan:</strong> {{ ucfirst($laporan->jenis_kerusakan) }}
    </div>
    <div class="mb-3">
        <strong>Deskripsi:</strong> {{ $laporan->deskripsi }}
    </div>
    <div class="mb-3">
        <strong>Foto Kerusakan:</strong>
        @foreach($laporan->fotoKerusakans as $foto)
            <img src="{{ asset('storage/' . $foto->path) }}" class="img-thumbnail" style="max-width: 200px;"/>
        @endforeach
    </div>

    <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ $laporan->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="rejected" {{ $laporan->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
