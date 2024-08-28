@extends('layout.main')

@section('container')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Barang</h1>
        <div>
            <a href="{{ route('barang.create') }}" class="btn btn-success btn-sm me-2">+ Tambah Barang</a>
            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary btn-sm">Kelola Jenis Barang</a>
        </div>
    </div>

    <!-- Display Options -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('barang.index', ['view' => 'table']) }}" class="btn btn-info btn-sm {{ request('view') == 'table' ? 'active' : '' }}">Tampilan Tabel</a>
            <a href="{{ route('barang.index', ['view' => 'card']) }}" class="btn btn-info btn-sm {{ request('view') == 'card' ? 'active' : '' }}">Tampilan Card</a>
        </div>
    </div>
   
    <!-- Filter Form -->
    <form action="{{ route('barang.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4 col-sm-6">
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
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Check View Option -->
    @if(request('view') == 'card')
        <!-- Card View -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($barangs as $barang)
                <div class="col mb-4">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ Storage::url('public/image/barang.png') }}" class="card-img-top" alt="{{ $barang->nama_barang }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title">{{ $barang->nama_barang }}</h6>
                            <p class="card-text mb-0">
                                Jenis: {{ $barang->jenisBarang->nama_jenis }}<br>
                               
                                
                                Pengguna: {{ $barang->user->username ?? 'Tidak Ada Pengguna' }}<br>
                               Stok: {{ $barang->stok }}
                               <br>
                               <br>
                          
                               
                               <div class="position-relative">
                                <div class="position-absolute bottom-0 end-0">
                                {!! DNS1D::getBarcodeSVG($barang->barcode, 'C39', 1, 33) !!}
                            </div>
                        </div>
                            </p>
                            <div class="d-flex justify-content-between mt-6">
                                <a href="{{ route('barang.edit', $barang) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('barang.destroy', $barang) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Table View -->
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Barcode</th>
                        <th>Stok</th>
                        <th>Pengguna</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($barangs as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->jenisBarang->nama_jenis }}</td>
                            <td>{!! DNS1D::getBarcodeSVG($barang->barcode, 'C39', 1, 33) !!}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>{{ $barang->user->username ?? 'Tidak Ada Pengguna' }}</td> 
                            <td>
                                <a href="{{ route('barang.edit', $barang) }}" class="btn btn-warning btn-sm me-1">Edit</a>
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

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-4">
            <li class="page-item {{ $barangs->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $barangs->previousPageUrl() }}">Previous</a>
            </li>
            @for ($i = 1; $i <= $barangs->lastPage(); $i++)
                <li class="page-item {{ $i == $barangs->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $barangs->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $barangs->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $barangs->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
</div>
@endsection
