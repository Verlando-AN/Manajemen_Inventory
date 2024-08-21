@extends('layout.main')

@section('container')
    <h1>Barang</h1>
    <a href="{{ route('barang.create') }}" class="btn btn-primary">Tambah Barang</a>
    <a href="{{ route('jenis_barang.create') }}" class="btn btn-warning">Tambah Jenis Barang</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Barcode</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
                <tr>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->jenisBarang->nama_jenis }}</td>
                    <td>{{ $barang->barcode }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>
                        <a href="{{ route('barang.edit', $barang) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy', $barang) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
