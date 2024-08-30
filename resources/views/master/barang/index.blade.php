@extends('layout.main')

@section('container')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Barang</h1>
        <div>
            <a href="{{ route('barang.create') }}" class="btn btn-success btn-sm me-2">+ Tambah Barang</a>
            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary btn-sm">Kelola Jenis Barang</a>
        </div>
    </div>

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('barang.index', ['view' => 'table']) }}" class="btn btn-info btn-sm {{ request('view') == 'table' ? 'active' : '' }}">Tampilan Tabel</a>
            <a href="{{ route('barang.index', ['view' => 'card']) }}" class="btn btn-info btn-sm {{ request('view') == 'card' ? 'active' : '' }}">Tampilan Card</a>
        </div>
    </div>

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
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle table-custom">
            <thead class="table-light text-center">
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

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-4">
            <li class="page-item {{ $barangs->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $barangs->appends(['view' => request('view')])->previousPageUrl() }}">Previous</a>
            </li>
            @for ($i = 1; $i <= $barangs->lastPage(); $i++)
                <li class="page-item {{ $i == $barangs->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $barangs->appends(['view' => request('view')])->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $barangs->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $barangs->appends(['view' => request('view')])->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

<style>
 .card-custom {
    max-width: 100%; /* Card menggunakan lebar penuh kolom */
    width: 100%; /* Card menyesuaikan lebar kolom */
}

.card-img-top {
    height: 180px; /* Ukuran gambar card */
    object-fit: cover; /* Menyesuaikan gambar */
}

.table-custom {
    font-size: 0.875rem; /* Mengurangi ukuran font tabel */
}

.butonn, .butond {
    border-radius: 5px;
    font-size: 0.875rem; /* Ukuran font tombol */
    padding: 0.5rem 1rem; /* Padding tombol yang lebih besar untuk konsistensi tinggi */
    color: #fff; /* Warna teks tombol */
    transition: background-color 0.3s ease, opacity 0.3s ease; /* Animasi saat hover */
    border: none; /* Menghapus border default */
    display: flex; /* Flexbox untuk menyeimbangkan konten */
    align-items: center; /* Vertikal align center */
    justify-content: center; /* Horizontal align center */
}

.butonn {
    background-color: rgb(255, 217, 4); /* Warna latar belakang tombol Edit */
}

.butond {
    background-color: rgb(255, 87, 34); /* Warna latar belakang tombol Hapus */
}

.butonn:hover, .butond:hover {
    opacity: 0.8; /* Efek hover untuk tombol */
}

.card-body .action-buttons {
    display: flex;
    gap: 0.5rem; /* Jarak antara tombol */
    justify-content: flex-end; /* Menempatkan tombol di pojok kanan */
}

@media (max-width: 768px) {
    .card-custom {
        max-width: 100%; /* Card menyesuaikan lebar pada layar kecil */
    }

    .card-img-top {
        height: 150px; /* Mengurangi ukuran gambar pada layar kecil */
    }

    .butonn, .butond {
        font-size: 0.75rem; /* Mengurangi ukuran font tombol pada layar kecil */
        padding: 0.4rem 0.8rem; /* Mengurangi padding tombol untuk layar kecil */
    }

    .table-custom {
        font-size: 0.75rem; /* Mengurangi ukuran font tabel pada layar kecil */
    }
}

@media (max-width: 576px) {
    .card-custom {
        max-width: 100%; /* Card menyesuaikan lebar pada layar sangat kecil */
    }

    .card-img-top {
        height: 100px; /* Mengurangi ukuran gambar pada layar sangat kecil */
    }

    .butonn, .butond {
        border-radius: 5px;
        font-size: 0.875rem; 
        height: 25px;
   
    }

    .table-custom {
        font-size: 0.7rem; /* Mengurangi ukuran font tabel pada layar sangat kecil */
    }
}

</style>
