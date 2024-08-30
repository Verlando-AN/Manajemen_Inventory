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

    <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-4">
                <label for="bulan">Bulan:</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="tahun">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @for($i = \Carbon\Carbon::now()->year; $i >= 2000; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Filter</button>
    </form>

    <table class="table table-bordered">
        <thead>
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
                        <div class="input-group mb-3">
                            <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                            <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-info btn-sm">Edit</a>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split btn-info" data-bs-toggle="dropdown" aria-expanded="false">
                              <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                              <li>
                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                                </form>
                              </li>
                            </ul>
                         </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item disabled">
        <a class="page-link">Previous</a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#">Next</a>
      </li>
    </ul>
</nav>

@endsection
