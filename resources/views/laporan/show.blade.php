@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">Detail Laporan</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Barcode:  {!! DNS1D::getBarcodeSVG($laporan->barcode, 'C39', 1, 33) !!}</h5>
            <p class="card-text">Nama Laptop: {{ $laporan->nama_laptop }}</p>
            <p class="card-text">Jenis Kerusakan: {{ $laporan->jenis_kerusakan }}</p>
            <p class="card-text">Deskripsi: {{ $laporan->deskripsi }}</p>
            <p>Status : {{ ucfirst($laporan->status->status ?? $laporan->status) }}</p>
            <p class="card-text">Estimasi Selesai: @if($laporan->status_id === 2)  
                {{ $laporan->estimasi_selesai ? \Carbon\Carbon::parse($laporan->estimasi_selesai)->format('d-m-Y') : '-' }}
            @else
                -
            @endif
        </p>
        </div>
    </div>

    <h3 class="mt-4">Foto Kerusakan</h3>
    <div class="row">
        @foreach($fotoKerusakans as $foto)
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $foto->path) }}" alt="Foto Kerusakan" class="img-thumbnail">
            </div>
        @endforeach
    </div>
</div>
@endsection
