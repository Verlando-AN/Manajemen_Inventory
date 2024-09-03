@extends('layout.main')

<link rel="stylesheet" href="{{ asset('css/deskripsi.css') }}">

@section('container')
<h1 class="heading">Details Barang</h1>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="profile-container">
                <div class="profile-photo">
                    @if($barang->fotoBarangs->count() > 0)
                        @foreach($barang->fotoBarangs as $foto)
                            <img src="{{ Storage::url($foto->path) }}" alt="{{ $barang->nama_barang }}">
                        @endforeach
                    @else
                        <p class="text-muted">Tidak ada foto tersedia.</p>
                    @endif
                </div>
                <div class="profile-details">
                    <h1 class="card-title">{{ $barang->nama_barang }}</h1>
                    <p class="card-text"><strong>Jenis:</strong> {{ $barang->jenisBarang->nama_jenis }}</p>
                    <p class="card-text"><strong>Pengguna:</strong> {{ $barang->user->username ?? 'Tidak Ada Pengguna' }}</p>
                    <p class="card-text"><strong>Stok:</strong> {{ $barang->stok }}</p>
                    <p class="card-text"><strong>Deskripsi:</strong> {{ $barang->deskripsi }}</p>
                </div>
            </div>


            <a href="{{ route('barang.index') }}" class="btn right-sm btn-primary mt-4 ">Kembali ke Daftar Barang</a>
        </div>
    </div>
</div>
@endsection
