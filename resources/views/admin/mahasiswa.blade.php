@extends('layouts.admin')
@section('title', 'Manajemen Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Mahasiswa</h3>
            <p class="text-slate-500 text-sm mt-1">Total <span class="font-bold text-slate-700">{{ $mahasiswas->count() }}</span> mahasiswa terdaftar.</p>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-sm shadow-blue-500/30 transition-all flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Tambah Data
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-4 px-6">Informasi Mahasiswa</th>
                    <th class="py-4 px-6">NIM</th>
                    <th class="py-4 px-6">Status Wajah AI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($mahasiswas as $mhs)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="py-4 px-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm ring-1 ring-indigo-100">
                            {{ strtoupper(substr($mhs->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $mhs->name }}</p>
                            <p class="text-xs text-slate-500">{{ $mhs->email }}</p>
                        </div>
                    </td>
                    <td class="py-4 px-6 font-mono text-sm font-semibold text-slate-700">{{ $mhs->nim ?? '-' }}</td>
                    <td class="py-4 px-6">
                        @if($mhs->face_embedding)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Wajah Tersimpan</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Belum Rekam</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection