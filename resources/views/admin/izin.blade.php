@extends('layouts.admin')
@section('title', 'Manajemen Perizinan')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Pengajuan Izin & Sakit</h1>
        <p class="text-sm text-gray-500 mt-1">Tinjau dokumen dan berikan persetujuan untuk absensi mahasiswa.</p>
    </div>

    <!-- Tempat Munculnya Notifikasi Sukses/Gagal -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 font-bold text-sm rounded-r-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 font-bold text-sm rounded-r-lg shadow-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Detail Pengajuan</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Dokumen Bukti</th>
                        <th class="py-4 px-6 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status & Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($izins as $index => $izin)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="py-4 px-6 text-sm text-slate-600 font-semibold">{{ $index + 1 }}</td>
                            
                            <td class="py-4 px-6 text-sm">
                                <div class="font-bold text-slate-900">{{ $izin->user->name ?? 'Tidak Dikenal' }}</div>
                                <div class="text-xs text-slate-500">{{ $izin->user->nim ?? '-' }}</div>
                            </td>

                            <td class="py-4 px-6 text-sm">
                                <span class="font-bold {{ $izin->jenis_izin == 'Sakit' ? 'text-rose-600' : 'text-amber-600' }}">
                                    {{ $izin->jenis_izin }}
                                </span>
                                <div class="text-slate-600 mt-1 text-xs whitespace-normal max-w-xs">{{ $izin->keterangan }}</div>
                                <div class="text-slate-400 mt-1 text-[10px]">{{ $izin->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            
                            <td class="py-4 px-6 text-sm">
                                @if($izin->bukti_file)
                                    <!-- Tombol untuk membuka file foto surat dokter -->
                                    <a href="{{ asset($izin->bukti_file) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-medium text-xs bg-blue-50 px-3 py-1.5 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-slate-400 italic text-xs">Tidak ada file</span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6 text-sm text-center">
                                <!-- Logika Munculnya Tombol Persetujuan -->
                                @if($izin->status == 'Menunggu')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.izin.approve', $izin->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.izin.reject', $izin->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $izin->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                                        {{ $izin->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500 font-medium">Belum ada pengajuan izin atau sakit dari mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection