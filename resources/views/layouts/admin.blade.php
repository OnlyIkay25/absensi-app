<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - HadirMas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-hidden">
    <div class="flex h-screen w-full">
        
        <aside class="hidden md:flex flex-col w-72 bg-[#0B1121] text-slate-300 h-full flex-shrink-0 border-r border-slate-800/60 shadow-2xl z-20">
            
            <div class="h-20 flex items-center px-8 border-b border-slate-800/60 bg-[#0B1121]">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-tr from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <span class="text-xl font-extrabold text-white tracking-tight">Hadir<span class="text-blue-500">Admin</span></span>
                </div>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg shadow-blue-500/25' : 'hover:bg-slate-800/50 text-slate-400 hover:text-slate-100 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.mahasiswa') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm group {{ request()->routeIs('admin.mahasiswa') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg shadow-blue-500/25' : 'hover:bg-slate-800/50 text-slate-400 hover:text-slate-100 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.mahasiswa') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Mahasiswa
                </a>

                <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm group {{ request()->routeIs('admin.absensi') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg shadow-blue-500/25' : 'hover:bg-slate-800/50 text-slate-400 hover:text-slate-100 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.absensi') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Data Absensi
                </a>

                <a href="{{ route('admin.izin') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition-all text-sm group {{ request()->routeIs('admin.izin') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg shadow-blue-500/25' : 'hover:bg-slate-800/50 text-slate-400 hover:text-slate-100 font-medium' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.izin') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Pengajuan Izin
                    </div>
                    @php $pendingIzin = \App\Models\Izin::where('status', 'Menunggu Review')->count(); @endphp
                    @if($pendingIzin > 0)
                        <span class="{{ request()->routeIs('admin.izin') ? 'bg-white text-blue-600 shadow-sm' : 'bg-rose-500 text-white shadow-lg shadow-rose-500/30' }} text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingIzin }}</span>
                    @endif
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800/60 mt-auto bg-[#0B1121]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-slate-400 hover:bg-rose-500/10 hover:text-rose-500 border border-transparent hover:border-rose-500/20 transition-all font-bold text-sm group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#F8FAFC]">
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0 z-10">
                <div class="flex items-center gap-4">
                    <h2 class="text-lg font-bold text-slate-800 tracking-tight">@yield('title')</h2>
                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] uppercase tracking-wider font-bold rounded-md border border-slate-200">Admin</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 bg-gradient-to-tr from-blue-600 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md ring-2 ring-white">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>