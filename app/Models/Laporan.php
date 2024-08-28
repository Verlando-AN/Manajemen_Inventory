<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'nama_laptop',
        'jenis_kerusakan',
        'deskripsi',
        'status_id',
        'estimasi_selesai',
    ];

    public function fotoKerusakans()
    {
        return $this->hasMany(FotoKerusakan::class, 'laporan_id'); 
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); 
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
