<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuss';

    protected $fillable = ['status'];
    
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'status_id');
    }
}
