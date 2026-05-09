<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: 1 Izin dimiliki oleh 1 Mahasiswa (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}