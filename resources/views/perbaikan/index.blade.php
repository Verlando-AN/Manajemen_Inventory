@extends('layout.main')

@section('container')
<link rel="stylesheet" href="{{ asset('css/barang.css') }}">
<div class="container mt-4 px-5"> 
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="heading">Progres Perbaikan</h1>
    </div>

    <a href="{{ route('laporan.create') }}" class="btn btn-primary mb-4 btn-filter">Tambah Laporan</a>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom table-custom-shadow">
            <thead class="table-dark">
                <tr>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Status</th>
                    <th>Estimasi Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporans as $laporan)
                    <tr>
                        <td>
                            {!! DNS1D::getBarcodeSVG($laporan->barcode, 'C39', 1, 33) !!}
                        </td>
                        <td>
                            <a href="{{ route('laporan.show', $laporan->id) }}" class="text-decoration-none">
                                {{ $laporan->nama_laptop }}
                            </a>
                        </td>
                        <td>{{ ucfirst($laporan->status->status ?? $laporan->status) }}</td>
                        <td>
                            @if(in_array($laporan->status_id, [2, 3, 4]))
                                {{ $laporan->estimasi_selesai ? \Carbon\Carbon::parse($laporan->estimasi_selesai)->format('d-m-Y') : '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($laporan->status_id === 3)
                            <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button 
                                    type="submit" 
                                    class="btn btn-success" 
                                    name="generate" 
                                    value="2"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#actionModal"
                                    data-action="generate"
                                >
                                    Terima
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage">Silakan Menunggu atau Mengantar Langsung Barang Anda ke Tim Repair</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmActionBtn">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('actionModal');
        const modalMessage = modal.querySelector('#modalMessage');
        const confirmActionBtn = modal.querySelector('#confirmActionBtn');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');

            if (action === 'generate') {
                modalMessage.textContent = 'Silakan antar Bbarang anda atau menunggu teknisi?';
                confirmActionBtn.textContent = 'Generate';
            } else if (action === 'accept') {
                modalMessage.textContent = 'Apakah Anda yakin ingin Accept Laporan ini?';
                confirmActionBtn.textContent = 'Accept';
            }
        });
    });
</script>

@endsection

<style>
    a.text-decoration-none:hover {
        text-decoration: underline;
    }

    .ms-2 {
        margin-left: 0.5rem;
    }
</style>
