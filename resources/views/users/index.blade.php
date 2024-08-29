@extends('layout.main')

@section('container')
<div class="container mt-4">
    <div class="text-center mb-4">
        <h1>Profile dan Barangmu</h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="row g-0">
                    <div class="col-md-12">
                        @if (auth()->user()->photo)
                      <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="User Image" class="img-fluid rounded-start" style="height: 200px; object-fit: cover;">
                      @else
                      <img src="{{ Storage::url('public/image/profile.jpg') }}" class="img-fluid rounded-top" alt="Profile Image" style="height: 250px; object-fit: cover;">
                      @endif
                     </div>
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <p class="card-text"><strong>Username:</strong> {{ Auth::user()->username }}</p>
                            <p class="card-text"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
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
                                @foreach($barangs->take(2) as $barang)
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
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <h5 class="card-title mt-4">Daftar Pengguna</h5>
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
        </div>
    </div>
</div>

<style>
.card {
  border-radius: 0.75rem;
  transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover {
  transform: scale(1.02);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}
.card img {
  border-bottom: 1px solid #dee2e6;
  border-radius: 0.75rem 0.75rem 0 0;
}
.card-body {
  padding: 1.5rem;
}

.table {
  border-radius: 0.75rem;
  overflow: hidden;
}
.table thead {
  background-color: #e9ecef;
}
.table th {
  font-weight: 600;
}
.table-hover tbody tr:hover {
  background-color: #f1f1f1;
}
.table-responsive {
  border-radius: 0.75rem;
}

.btn {
  border-radius: 0.5rem;
  transition: background-color 0.3s, border-color 0.3s;
}
.btn:hover {
  opacity: 0.9;
}
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}
.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}
.btn-outline-warning {
  border-color: #ffc107;
}
.btn-outline-warning:hover {
  background-color: #ffc107;
  color: #212529;
}
.btn-outline-danger {
  border-color: #dc3545;
}
.btn-outline-danger:hover {
  background-color: #dc3545;
  color: #fff;
}
.form-control {
  border-radius: 0.5rem;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}

.alert {
  border-radius: 0.5rem;
  font-size: 0.875rem;
}
.alert-dismissible .btn-close {
  filter: brightness(0.8);
}
.alert-dismissible .btn-close:hover {
  filter: brightness(1);
}

.container {
  margin-top: 2rem;
}
.text-center {
  margin-bottom: 2rem;
}
.mb-4 {
  margin-bottom: 2rem !important;
}
</style>
@endsection
