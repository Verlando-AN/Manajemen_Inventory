<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    // Jika nama tabel adalah 'statuss', maka ini sudah benar
    protected $table = 'statuss';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = ['status'];
    
    // Definisikan relasi ke model Laporan
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'status_id');
    }
}
