<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_barang_id', 'user_id', 'nama_barang', 'barcode', 'stok', 'deskripsi'];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
    public function fotobarangs()
    {
        return $this->hasMany(FotoBarang::class, 'barang_id'); 
    }
}
