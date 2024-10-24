@extends('layout.main')

@section('container')
<link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container mt-4">
    <div class="heading-container mb-4">
        <h1 class="heading">Daftar Laporan Kerusakan</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user()->role === 'admin')
    <a href="{{ route('laporan.create') }}" class="btn btn-primary mb-4 btn-filter">Tambah Laporan</a>
    @endif

    <form action="{{ route('laporan.index') }}" method="GET" class="filter-form">
        <div class="row">
            <div class="col-md-2 mb-2">
                <label for="tanggal" data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih tanggal untuk filter laporan">Tanggal Mulai:</label>
                <input type="text" name="tanggal_mulai" id="tanggal_mulai" class="form-control datepicker" placeholder="Pilih tanggal">
            </div>
            <div class="col-md-2 mb-2">
                <label for="tanggal_akhir" data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih tanggal akhir untuk filter laporan">Tanggal Akhir:</label>
                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control datepicker" placeholder="Pilih tanggal">
            </div>
            <div class="col-md-2 mb-2">
                <label for="bulan" data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih bulan untuk filter laporan">Bulan:</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <label for="tahun" data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih tahun untuk filter laporan">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach(range(\Carbon\Carbon::now()->year, 2000) as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">
            <i class="fa fa-filter"></i> Filter
        </button>
        <div class="mt-3">
            <button type="button" class="btn btn-secondary btn-sm" onclick="setPreset('today')">Hari Ini</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="setPreset('last7days')">7 Hari Terakhir</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="setPreset('thismonth')">Bulan Ini</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="setPreset('thisyear')">Tahun Ini</button>
        </div>
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d"
        });

        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (element) {
            new bootstrap.Tooltip(element);
        });

        function setPreset(preset) {
            let startDate, endDate;
            if (preset === 'today') {
                startDate = endDate = new Date().toISOString().split('T')[0];
            } else if (preset === 'last7days') {
                endDate = new Date().toISOString().split('T')[0];
                startDate = new Date();
                startDate.setDate(startDate.getDate() - 7);
                startDate = startDate.toISOString().split('T')[0];
            } else if (preset === 'thismonth') {
                startDate = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
                endDate = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).toISOString().split('T')[0];
            } else if (preset === 'thisyear') {
                startDate = new Date(new Date().getFullYear(), 0, 1).toISOString().split('T')[0];
                endDate = new Date(new Date().getFullYear(), 11, 31).toISOString().split('T')[0];
            }
            document.getElementById('tanggal_mulai').value = startDate;
            document.getElementById('tanggal_akhir').value = endDate;
        }
    </script>

    <div class="table-responsive">
        <table class="table-custom">
            <thead class="thead-dark">
                <tr>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Jenis Kerusakan</th>
                    <th>Tanggal Laporan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporans as $laporan)
                    <tr>
                        <td>
                            {!! DNS1D::getBarcodeSVG($laporan->barcode, 'C39', 1, 33) !!}
                        </td>
                        <td>{{ $laporan->nama_laptop }}</td>
                        <td>{{ ucfirst($laporan->jenis_kerusakan) }}</td>
                        <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
                        <td>
                            @if(auth()->user()->role === 'teknisi')
                            <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-info btn-sm">Terima</a>
                            @endif
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <nav aria-label="Page navigation example" class="pagination-container">
        <ul class="pagination">
            <li class="page-item {{ $laporans->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $laporans->appends(['view' => request('view')])->previousPageUrl() }}">Prev</a>
            </li>
            @for ($i = 1; $i <= $laporans->lastPage(); $i++)
                <li class="page-item {{ $i == $laporans->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $laporans->appends(['view' => request('view')])->url($i) }}">{{ $i }}</a>
                @endfor
                <li class="page-item {{ $laporans->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $laporans->appends(['view' => request('view')])->nextPageUrl() }}">Next</a>
                </li>
        </ul>
    </nav>
</div>
@endsection
