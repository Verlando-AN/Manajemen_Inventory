<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = ['perbaikan_id', 'tanggal_reminder', 'keterangan'];

    public function perbaikan()
    {
        return $this->belongsTo(Perbaikan::class);
    }
}
