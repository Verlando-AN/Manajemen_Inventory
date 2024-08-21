<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoKerusakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'path',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
