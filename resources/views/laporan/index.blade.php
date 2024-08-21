@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Laporan Kerusakan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('laporan.create') }}" class="btn btn-primary mb-4">Tambah Laporan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Barcode</th>
                <th>Nama Laptop</th>
                <th>Jenis Kerusakan</th>
                <th>Tanggal Laporan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $laporan)
                <tr>
                    <td>{{ $laporan->barcode }}</td>
                    <td>{{ $laporan->nama_laptop }}</td>
                    <td>{{ ucfirst($laporan->jenis_kerusakan) }}</td>
                    <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
