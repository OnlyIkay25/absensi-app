@extends('layouts.admin')
@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Log Absensi Harian</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau kehadiran mahasiswa secara real-time.</p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.export.excel') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ekspor Excel
            </a>
            <a href="{{ route('admin.export.pdf') }}" target="_blank" class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                Ekspor PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase tracking-wider">Nama Mahasiswa</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase tracking-wider">Waktu & Hari</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase tracking-wider">Mata Kuliah & Dosen</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase tracking-wider">Bukti Foto</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($absensis as $absen)
                        @php
                            // Logika Pendeteksi Mata Kuliah
                            $waktu = \Carbon\Carbon::parse($absen->waktu_absen);
                            $hari = $waktu->translatedFormat('l');
                            $jam = $waktu->format('H:i');
                            
                            $mk = 'Mata Kuliah Pengganti';
                            $dosen = 'Dosen Pengampu';

                            if ($hari == 'Senin') { 
                                $mk = 'Kriptografi'; $dosen = 'Erick Harlest Budi Harjo';
                            } elseif ($hari == 'Selasa') { 
                                if ($jam < '19:00') { $mk = 'Virtual dan Augmented'; $dosen = 'Muhammad Muharrom'; }
                                else { $mk = 'Proyek Teknologi Informasi'; $dosen = 'Dr. Heri Kuswara'; }
                            } elseif ($hari == 'Rabu') { 
                                if ($jam < '19:00') { $mk = 'Pengolah Citra'; $dosen = 'Giatika Chrisnawati'; }
                                else { $mk = 'Cloud Computering'; $dosen = 'Hidayat Muhammad Nur'; }
                            } elseif ($hari == 'Kamis') { 
                                if ($jam < '19:00') { $mk = 'Arsitektur Enterprise'; $dosen = 'Rinawati'; }
                                else { $mk = 'Internet Of Things'; $dosen = 'Sigit Wibawa'; }
                            }
                        @endphp

                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm">
                                    {{ $absen->user->name ?? 'Mahasiswa Dihapus' }}
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $hari }}</div>
                                <div class="text-sm text-slate-500">{{ $waktu->format('d M Y - H:i') }}</div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-bold text-blue-600 text-sm">{{ $mk }}</div>
                                <div class="text-sm text-slate-500">Dosen: {{ $dosen }}</div>
                            </td>
                            
                            <td class="py-4 px-6">
                                @if(strtolower($absen->status) == 'hadir')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded bg-emerald-100 text-emerald-700">
                                        Hadir
                                    </span>
                                @elseif(strtolower($absen->status) == 'izin' || strtolower($absen->status) == 'sakit')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded bg-amber-100 text-amber-700">
                                        {{ $absen->status }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded bg-rose-100 text-rose-700">
                                        {{ $absen->status }}
                                    </span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6">
                                @if($absen->foto_snapshot)
                                    <img src="{{ $absen->foto_snapshot }}" alt="Bukti" class="h-12 w-20 object-cover rounded-md shadow-sm border border-slate-200 hover:scale-150 transition transform origin-right cursor-pointer">
                                @else
                                    <span class="text-gray-400 italic text-sm">No Photo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="font-medium text-slate-500">Belum ada mahasiswa yang absen hari ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection