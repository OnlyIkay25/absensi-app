@extends('layouts.admin')
@section('title', 'Overview Dashboard')

@section('content')
    <!-- Banner -->
    <div class="bg-blue-600 rounded-3xl p-8 text-white shadow-lg shadow-blue-600/20 mb-8">
        <h3 class="text-3xl font-extrabold mb-2">Selamat Datang di Panel Admin! 🚀</h3>
        <p class="text-blue-100 max-w-2xl">Pantau seluruh aktivitas absensi mahasiswa, kelola data, dan setujui perizinan terpusat.</p>
    </div>

    <!-- 4 Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Mahasiswa</p>
                <h4 class="text-2xl font-extrabold text-slate-900">124</h4>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Hadir Hari Ini</p>
                <h4 class="text-2xl font-extrabold text-slate-900">110</h4>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Izin / Sakit</p>
                <h4 class="text-2xl font-extrabold text-slate-900">3</h4>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Alfa / Bolos</p>
                <h4 class="text-2xl font-extrabold text-slate-900">11</h4>
            </div>
        </div>
    </div>
@endsection