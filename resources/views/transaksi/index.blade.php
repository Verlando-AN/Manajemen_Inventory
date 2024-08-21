@extends('layouts.app')

@section('content')
    <h1>Transaksi Barang</h1>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
    <table class="table">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Tanggal Transaksi</th>
                <th>Jumlah</th>
                <th>Jenis Transaksi</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->barang->nama_barang }}</td>
                    <td>{{ $transaksi->tanggal_transaksi }}</td>
                    <td>{{ $transaksi->jumlah }}</td>
                    <td>{{ $transaksi->jenis_transaksi }}</td>
                    <td>{{ $transaksi->keterangan }}</td>
                    <td>
                        <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-info">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
