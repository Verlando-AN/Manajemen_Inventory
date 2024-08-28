
@extends('layout.main')

@section('container')
<div class="container mt-4">
    <h1 class="mb-4">{{ isset($laporan) ? 'Edit' : 'Tambah' }} Laporan Kerusakan</h1>

    <form action="{{ isset($laporan) ? route('laporan.update', $laporan->id) : route('laporan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($laporan))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="barcode" class="form-label">Barcode</label>
            <div class="input-group">
                <input type="text" name="barcode" id="barcode" class="form-control" value="{{ old('barcode', $laporan->barcode ?? '') }}" required>
                <button type="button" class="btn btn-primary" id="scan-barcode-btn">Scan</button>
            </div>
            <div id="barcode-reader" style="width: 100%; max-width: 400px; height: 300px; display: none; margin-top: 10px;"></div>
        </div>

        <div class="mb-3">
            <label for="nama_laptop" class="form-label">Nama Tipe</label>
            <input type="text" name="nama_laptop" id="nama_laptop" class="form-control" value="{{ old('nama_laptop', $laporan->nama_laptop ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan</label>
            <select name="jenis_kerusakan" id="jenis_kerusakan" class="form-select" required>
                <option value="normal" {{ (old('jenis_kerusakan', $laporan->jenis_kerusakan ?? '') == 'normal') ? 'selected' : '' }}>Normal</option>
                <option value="sedang" {{ (old('jenis_kerusakan', $laporan->jenis_kerusakan ?? '') == 'sedang') ? 'selected' : '' }}>Sedang</option>
                <option value="parah" {{ (old('jenis_kerusakan', $laporan->jenis_kerusakan ?? '') == 'parah') ? 'selected' : '' }}>Parah</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi', $laporan->deskripsi ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="foto_kerusakan" class="form-label">Foto Kerusakan (Opsional)</label>
            <input type="file" name="foto_kerusakan[]" id="foto_kerusakan" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($laporan) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<script>
    const scanButton = document.getElementById('scan-barcode-btn');
    const barcodeReader = document.getElementById('barcode-reader');
    const barcodeInput = document.getElementById('barcode');

    let html5QrCode;

    scanButton.addEventListener('click', () => {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("barcode-reader");
        }
        barcodeReader.style.display = 'block';
        html5QrCode.start({ facingMode: "environment" }, {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        },
        (decodedText) => {
            barcodeInput.value = decodedText;
            html5QrCode.stop().then(() => {
                barcodeReader.style.display = 'none';
            }).catch(err => {
                console.error("Unable to stop scanning", err);
            });
        }).catch(err => {
            console.error("Unable to start scanning", err);
        });
    });
</script>
@endsection
