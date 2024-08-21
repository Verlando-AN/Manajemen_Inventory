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
    ];

    public function fotoKerusakans()
    {
        return $this->hasMany(FotoKerusakan::class);
    }
}
