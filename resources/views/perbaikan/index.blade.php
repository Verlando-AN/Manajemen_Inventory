@extends('layout.main')

@section('container')
<div class="container mt-4 px-5"> <!-- Menambahkan padding pada container -->
    <h1 class="mb-4 text-center">Progres Perbaikan</h1>

    <a href="{{ route('laporan.create') }}" class="btn btn-primary mb-4">Tambah Laporan</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Barcode</th>
                    <th>Nama Laptop</th>
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
                            @if($laporan->status_id === 2)  
                                {{ $laporan->estimasi_selesai ? \Carbon\Carbon::parse($laporan->estimasi_selesai)->format('d-m-Y') : '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="d-grid gap-2 d-md-block">
                                <button 
                                    class="btn btn-primary {{ $laporan->status_id == 2 ? '' : 'disabled' }}" 
                                    type="button"
                                    data-bs-toggle="modal" data-bs-target="#actionModal" 
                                    data-action="generate"
                                    data-id="{{ $laporan->id }}"
                                    {{ $laporan->status_id != 2 ? 'disabled' : '' }}
                                >
                                    Generate
                                </button>

                                <button 
                                    class="btn btn-success {{ $laporan->status_id == 4 ? '' : 'disabled' }} ms-2" 
                                    type="button"
                                    data-bs-toggle="modal" data-bs-target="#actionModal" 
                                    data-action="accept"
                                    data-id="{{ $laporan->id }}"
                                    {{ $laporan->status_id != 4 ? 'disabled' : '' }}
                                >
                                    Accept
                                </button>
                            </div>
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

<!-- Script to change modal content based on action -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('actionModal');
        const modalMessage = modal.querySelector('#modalMessage');
        const confirmActionBtn = modal.querySelector('#confirmActionBtn');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');

            if (action === 'generate') {
                modalMessage.textContent = 'Apakah Anda yakin ingin Generate Laporan ini?';
                confirmActionBtn.textContent = 'Generate';
            } else if (action === 'accept') {
                modalMessage.textContent = 'Apakah Anda yakin ingin Accept Laporan ini?';
                confirmActionBtn.textContent = 'Accept';
            }
        });
    });
</script>

@endsection

<!-- Custom CSS -->
<style>
    /* Add hover effect to links */
    a.text-decoration-none:hover {
        text-decoration: underline;
    }

    /* Add more spacing between buttons */
    .ms-2 {
        margin-left: 0.5rem;
    }
</style>
