<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Mengambil data absensi beserta data user-nya, diurutkan dari yang terbaru
        return Absensi::with('user')->orderBy('waktu_absen', 'desc')->get();
    }

    public function headings(): array
    {
        // Ini untuk judul kolom (header) di baris pertama Excel
        return [
            'Nama Mahasiswa', 
            'NIM', 
            'Waktu Absen', 
            'Hari & Tanggal', 
            'Mata Kuliah', 
            'Status'
        ];
    }

    public function map($absen): array
    {
        // Logika pintar pendeteksi mata kuliah
        $waktu = \Carbon\Carbon::parse($absen->waktu_absen);
        $hari = $waktu->translatedFormat('l');
        $jam = $waktu->format('H:i');
        
        $mk = 'Mata Kuliah Pengganti';
        if ($hari == 'Senin') { 
            $mk = 'Kriptografi'; 
        } elseif ($hari == 'Selasa') { 
            $mk = ($jam < '19:00') ? 'Virtual dan Augmented' : 'Proyek Teknologi Informasi'; 
        } elseif ($hari == 'Rabu') { 
            $mk = ($jam < '19:00') ? 'Pengolah Citra' : 'Cloud Computering'; 
        } elseif ($hari == 'Kamis') { 
            $mk = ($jam < '19:00') ? 'Arsitektur Enterprise' : 'Internet Of Things'; 
        }

        // Susunan data yang dimasukkan ke baris Excel
        return [
            $absen->user->name ?? 'User Dihapus',
            $absen->user->nim ?? '-',
            $waktu->format('H:i:s'),
            $hari . ', ' . $waktu->format('d M Y'),
            $mk,
            $absen->status
        ];
    }
}