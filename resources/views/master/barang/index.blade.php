@extends('layout.main')

@section('container')
<div class="container">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/barang.css') }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="heading">Daftar Barang</h1>
        <div>
            <a href="{{ route('barang.create') }}" class="btn btn-success btn-sm me-2">+ Tambah Barang</a>
            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary btn-sm">Kelola Jenis Barang</a>
        </div>
    </div>

    <!-- View Toggle Buttons -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('barang.index', ['view' => 'table']) }}" class="btn btn-primary mb-4 btn-filter {{ request('view') == 'table' ? 'active' : '' }}">Tampilan Tabel</a>
            <a href="{{ route('barang.index', ['view' => 'card']) }}" class="btn btn-primary mb-4 btn-filter {{ request('view') == 'card' ? 'active' : '' }}">Tampilan Card</a>
        </div>
    </div>

    <!-- Filter Section -->
    <form action="{{ route('barang.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-2 col-sm-6">
                <label for="jenis_barang_id" class="form-label">Jenis Barang:</label>
                <select name="jenis_barang_id" id="jenis_barang_id" class="form-select">
                    <option value="">Semua Jenis Barang</option>
                    @foreach($jenisBarangs as $jenisBarang)
                        <option value="{{ $jenisBarang->id }}" {{ request('jenis_barang_id') == $jenisBarang->id ? 'selected' : '' }}>
                            {{ $jenisBarang->nama_jenis }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-6 align-self-end">
                <button type="submit" class="btn btn-primary w-50">Filter</button>
            </div>
        </div>
    </form>

    <!-- Card View -->
    @if(request('view') == 'card')
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4">
        @foreach($barangs as $barang)
            <div class="col mb-4">
                <div class="card card-custom">
                    <a href="{{ route('barang.show', $barang) }}" class="text-decoration-none text-dark">
                        @if($barang->fotoBarangs->count() > 0)
                            <img src="{{ Storage::url($barang->fotoBarangs->first()->path) }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
                        @else
                            <img src="{{ Storage::url('public/image/barang.png') }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ $barang->nama_barang }}</h6>
                            <p class="card-text mb-0">
                                Jenis: {{ $barang->jenisBarang->nama_jenis }}<br>
                                Pengguna: {{ $barang->user->username ?? 'Tidak Ada Pengguna' }}<br>
                            </p>
                            <div class="action-buttons mt-2">
                                <a href="{{ route('barang.edit', $barang) }}" class="butonn">Edit</a>
                                <form action="{{ route('barang.destroy', $barang) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="butond">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <!-- Table View -->
    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom table-custom-shadow">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Pengguna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($barangs as $barang)
                    <tr>
                        <td><a href="{{ route('barang.show', $barang) }}" class="text-decoration-none">{{ $barang->nama_barang }}</a></td>
                        <td>{{ $barang->jenisBarang->nama_jenis }}</td>
                        <td>{{ $barang->user->username ?? 'Tidak Ada Pengguna' }}</td>
                        <td>
                            <a href="{{ route('barang.edit', $barang) }}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{ route('barang.destroy', $barang) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <nav aria-label="Page navigation example" class="pagination-container">
        <ul class="pagination">
            <li class="page-item {{ $barangs->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $barangs->appends(['view' => request('view')])->previousPageUrl() }}">Prev</a>
            </li>
            @for ($i = 1; $i <= $barangs->lastPage(); $i++)
                <li class="page-item {{ $i == $barangs->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $barangs->appends(['view' => request('view')])->url($i) }}">{{ $i }}</a>
                @endfor
                <li class="page-item {{ $barangs->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $barangs->appends(['view' => request('view')])->nextPageUrl() }}">Next</a>
                </li>
        </ul>
    </nav>
    
    
</div>
@endsection