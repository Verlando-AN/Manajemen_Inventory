@extends('layout.main')

@section('container')
<div class="container mt-4">
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
                        <td>{{ $laporan->nama_laptop }}</td>
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
                                    {{ $laporan->status_id != 2 ? 'disabled' : '' }}
                                >
                                    Generate
                                </button>
                                <button 
                                    class="btn btn-success {{ $laporan->status_id == 4 ? '' : 'disabled' }}" 
                                    type="button"
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
@endsection
