<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_barang_id', 'user_id', 'nama_barang', 'barcode', 'stok', 'deskripsi'];

    // Mengubah nama relasi menjadi bentuk tunggal
    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class); // belongsTo harus bentuk tunggal
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Nama metode disarankan tunggal
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function fotobarangs()
    {
        return $this->hasMany(FotoBarang::class, 'barang_id'); 
    }
}
