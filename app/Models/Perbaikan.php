<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;

    protected $fillable = ['transaksi_id', 'tanggal_perbaikan', 'keterangan_perbaikan', 'status'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function reminder()
    {
        return $this->hasOne(Reminder::class);
    }
}
