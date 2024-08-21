@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Jenis Barang</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('jenis_barang.create') }}" class="btn btn-primary mb-3">Tambah Jenis Barang</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Jenis</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jenisBarangs as $jenisBarang)
                <tr>
                    <td>{{ $jenisBarang->nama_jenis }}</td>
                    <td>{{ $jenisBarang->stok }}</td>
                    <td>
                        <a href="{{ route('jenis_barang.edit', $jenisBarang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jenis_barang.destroy', $jenisBarang->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis barang ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
