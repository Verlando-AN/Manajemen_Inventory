<link rel="stylesheet" href="{{ asset('css/home.css') }}">

@extends('layout.main')

@section('container')
<div class="container mt-4">

    <!-- Header Section -->
    <header class="text-left mb-4 position-relative">
    <!-- Logo -->
    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
    
    <h1 class="header-title">Selamat Datang di Aplikasi Kami</h1>
    <p class="header-subtitle">Kelola laporan dengan mudah dan efisien.</p>
    </header>

    <!-- Overview Section -->
    <section class="overview-section mb-4 p-4 container">
        <h2>Ringkasan Data</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Laporan</h5>
                        <p class="card-text">{{ $jumlahLaporan }}</p> <!-- Menampilkan jumlah laporan -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Terbaru</h5>
                        <!-- Menampilkan laporan terbaru jika ada -->
                        @if($laporanTerbaru)
                            <p class="card-text">{{ $laporanTerbaru->nama_laptop }} - {{ $laporanTerbaru->jenis_kerusakan }}</p>
                        @else
                            <p class="card-text">Belum ada laporan.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Aktivitas Terakhir</h5>
                        <!-- Menampilkan aktivitas terakhir jika ada -->
                        @if($aktivitasTerakhir)
                            <p class="card-text"> {{ $aktivitasTerakhir->user_id }} menambahkan laporan {{ $aktivitasTerakhir->nama_laptop }} pada {{ $aktivitasTerakhir->created_at->format('d-m-Y') }}.</p>
                        @else
                            <p class="card-text">Belum ada aktivitas terbaru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section mb-4 p-4 container">
        <h2>Fitur Utama</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <span class="feature-icon-text">📊</span>
                    </div>
                    <h3>Dashboard</h3>
                    <p>Lihat ringkasan dan statistik penting tentang laporan, aktivitas terbaru, dan tren yang sedang berlangsung.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <span class="feature-icon-text">📝</span>
                    </div>
                    <h3>Pengelolaan Laporan</h3>
                    <p>Kelola laporan dengan mudah, mulai dari pembuatan, pembaruan, hingga penghapusan laporan.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <span class="feature-icon-text">🔍</span>
                    </div>
                    <h3>Pencarian dan Filter</h3>
                    <p>Cari dan filter laporan berdasarkan berbagai kriteria seperti tanggal, jenis kerusakan, atau nama laptop.</p>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
