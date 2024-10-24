@extends('layout.main')

@section('container')
<div class="container mt-5">
    <link rel="stylesheet" href="{{ asset('css/barang.css') }}">
    <header class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="heading">Detail Laporan Kerusakan</h1>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary btn-lg">Kembali</a>
    </header>

    <div class="card shadow border-0 rounded">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-4">
                    @if($laporan->fotoKerusakans->count())
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $laporan->fotoKerusakans->first()->path) }}" class="img-fluid rounded-top" style="height: 300px; object-fit: cover;" alt="Foto Kerusakan"/>
                            <div class="position-absolute top-0 start-0 p-3 bg-dark bg-opacity-50 text-white rounded-end">
                                <h5 class="card-title fs-4 mb-1">{{ $laporan->nama_laptop }}</h5>
                                <p class="card-text mb-0">{{ ucfirst($laporan->jenis_kerusakan) }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-center text-muted">Tidak ada foto kerusakan tersedia.</p>
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="mb-3    md-3">
                        <h5 class="text-primary">Detail Laporan</h5>
                        <dl class="row">
                            <dt class="col-sm-4 text-muted">Nama Laptop:</dt>
                            <dd class="col-sm-8">{{ $laporan->nama_laptop }}</dd>
                            <dt class="col-sm-4 text-muted">Barcode:</dt>
                            <dd class="col-sm-8">{{ $laporan->barcode }}</dd>
                            <dt class="col-sm-4 text-muted">Jenis Kerusakan:</dt>
                            <dd class="col-sm-8">{{ ucfirst($laporan->jenis_kerusakan) }}</dd>
                            <dt class="col-sm-4 text-muted">Deskripsi:</dt>
                            <dd class="col-sm-8">{{ $laporan->deskripsi }}</dd>
                            <p class="card-text">Teknisi: {{ $laporan->teknisi }}</p>
                            <p class="card-text">Estimasi Biaya: Rp. {{ $laporan->estimasi_biaya }}
                            <p class="card-text">Estimasi Selesai: 
                                {{ $laporan->estimasi_selesai ? \Carbon\Carbon::parse($laporan->estimasi_selesai)->format('d-m-Y') : '-' }}
                        </p>
                        </dl>
                    </div>

                    
                </div>
                <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        @if($laporan->status_id === 2 && auth()->user()->role === 'admin')
                        <button type="submit" class="btn btn-success" name="terima" value="2">
                            Terima
                        </button>
                        @endif
         
                        @if($laporan->status_id === 1 && auth()->user()->role === 'teknisi')
                    <div class="mb-2">
                        <label for="teknisi" class="form-label">Teknisi</label>
                        <input type="text" name="teknisi" id="teknisi" class="form-control" 
                               value="{{ old('teknisi', $laporan->teknisi) }}">
                    </div>

                    <div class="mb-2">
                        <label for="estimasi_biaya" class="form-label">Estimasi Biaya</label>
                        <input type="text" name="estimasi_biaya" id="estimasi_biaya" class="form-control" 
                               value="{{ old('estimasi_biaya', $laporan->estimasi_biaya) }}">
                    </div>

                    <div class="mb-2">
                        <label for="estimasi_selesai" class="form-label">Estimasi Selesai</label>
                        <input type="date" name="estimasi_selesai" id="estimasi_selesai" class="form-control" 
                               value="{{ old('estimasi_selesai', $laporan->estimasi_selesai ? \Carbon\Carbon::parse($laporan->estimasi_selesai)->format('Y-m-d') : '') }}">
                    </div>
                    

                    

                    <div class="text-center">
                            <button type="submit" name="terimateknisi" class="btn btn-primary btn-lg">Terima</button>
                       
                    </div>
                    
                    @endif

                    @if($laporan->status_id === 4 && auth()->user()->role === 'teknisi')
                    <button type="submit" class="btn btn-success" name="selesai" value="4">
                        Selesai
                    </button>
                @endif
                
                   
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
