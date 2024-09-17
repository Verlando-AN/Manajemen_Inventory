@extends('layout.main')

<<<<<<< HEAD
@section('container')
<div class="container">
    <h1>{{ $barang->nama_barang }}</h1>
    <p>Jenis: {{ $barang->jenisBarang->nama_jenis }}</p>
    <p>Pengguna: {{ $barang->user->username ?? 'Tidak Ada Pengguna' }}</p>
    <p>Stok: {{ $barang->stok }}</p>
    
        {!! DNS1D::getBarcodeSVG($barang->barcode, 'C39', 1, 33) !!}
    
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
=======
<link rel="stylesheet" href="{{ asset('css/deskripsi.css') }}">
>>>>>>> 7f6d5474a0d21c1430964c3dc852053cc36ea25d

@section('container')
<h1 class="heading">Details Barang</h1>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="profile-container">
                <div class="profile-photo">
                    @if($barang->fotoBarangs->count() > 0)
                        <div id="carouselExampleControls" class="carousel slide">
                            <div class="carousel-inner">
                                @foreach($barang->fotoBarangs as $index => $foto)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ Storage::url($foto->path) }}" alt="{{ $barang->nama_barang }}" class="d-block w-100">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada foto tersedia.</p>
                    @endif
                </div>
                <div class="profile-details">
                    <h1 class="profile-title">{{ $barang->nama_barang }}</h1>
                    <p class="card-text"><strong>Jenis:</strong> {{ $barang->jenisBarang->nama_jenis }}</p>
                    <p class="card-text"><strong>Stok:</strong> {{ $barang->stok }}</p>
                    <p class="card-text"><strong>Ditambahkan pada:</strong> {{ $barang->created_at->format('d M Y H:i') }}</p>
                    <p class="card-text"><strong>Pengguna:</strong> {{ $barang->user->username ?? 'Tidak Ada Pengguna' }}</p>
                    <p class="card-text"><strong>Deskripsi:</strong> {{ $barang->deskripsi }}</p>
                </div>
                <div class="barcode-container">
                    <p class="card-text"><strong></strong> {!! DNS1D::getBarcodeSVG($barang->barcode, 'C39', 0.8, 80) !!}</p>
                </div>
            </div>
            <div class="button-wrapper">
                <a href="{{ route('barang.index') }}" class="btn btn-primary">Kembali ke Daftar Barang</a>
            </div>
        </div>
    </div>
</div>
@endsection
    