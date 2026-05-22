<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Menggabungkan data absen dengan data mahasiswa di tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}