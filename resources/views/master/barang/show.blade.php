@extends('layout.main')

@section('container')
<div class="container">
    <h1>{{ $barang->nama_barang }}</h1>
    <p>Jenis: {{ $barang->jenisBarang->nama_jenis }}</p>
    <p>Pengguna: {{ $barang->user->username ?? 'Tidak Ada Pengguna' }}</p>
    <p>Stok: {{ $barang->stok }}</p>
    <p>Deskripsi: {{ $barang->deskripsi }}</p>
    
    @if($barang->fotoBarangs->count() > 0)
        <div class="row">
            @foreach($barang->fotoBarangs as $foto)
                <div class="col-md-4">
                    <img src="{{ Storage::url($foto->path) }}" class="img-fluid" alt="{{ $barang->nama_barang }}">
                </div>
            @endforeach
        </div>
    @else
        <p>Tidak ada foto tersedia.</p>
    @endif

    <a href="{{ route('barang.index') }}" class="btn btn-primary mt-4">Kembali ke Daftar Barang</a>
</div>
@endsection
