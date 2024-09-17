@extends('layout.main')

@section('container')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="container mt-4">
    <div class="text-left mb-4">
        <h1 class="heading">Profile dan Barangmu</h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row">
      <!-- Profile Section -->
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-light">
            <div class="row g-0 justify-content-center">
                <div class="col-md-12 d-flex justify-content-center">
                    @if (auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="User Image" class="img-fluid rounded-circle profile-photo">
                    @else
                        <img src="{{ Storage::url('public/img/profile.jpg') }}" class="img-fluid rounded-circle profile-photo" alt="Profile Image">
                    @endif
                </div>
                <div class="col-md-12">
                    <div class="card-body text-center">
                        <h5 class="card-title"><strong>{{ auth()->user()->username }}</strong></h5>
                        <div class="card-textt">
                            <p class="card-textt-role">{{ auth()->user()->role }}</p>
                        </div>
                        <a href="{{ route('users.edit', auth()->user()->id) }}" class="btn btn-outline-warning">
                          <i class="bi bi-pencil"></i> Edit Profile 
                        </a>
                        <p class="card-text"><strong>Email:</strong> {{ auth()->user()->email }}</p>                      
                    </div>
                </div>
            </div>
        </div>
      </div>

      <!-- Daftar Pengguna and Barangmu Section -->
      <div class="col-md-8 mb-4">
        <!-- Daftar Pengguna Section -->
        @if(auth()->user()->role === 'admin')
            <div class="card shadow-sm border-light mb-4">
                <div class="card-body">
                    <h5 class="card-title mt-2">Daftar Pengguna</h5>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users->take(2) as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-warning btn-sm me-2">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Barangmu Section -->
        <div class="card shadow-sm border-light">
            <div class="card-body">
                <h5 class="card-title">Barangmu</h5>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-secondary">
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
                            @foreach($barangs->where('user_id', auth()->user()->id) as $barang)
                                <tr>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->jenisBarang->nama_jenis }}</td>
                                    <td>{!! DNS1D::getBarcodeSVG($barang->barcode, 'C39', 1, 33) !!}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>{{ $barang->user->username ?? 'Tidak Ada Pengguna' }}</td>
                                    <td>
                                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
