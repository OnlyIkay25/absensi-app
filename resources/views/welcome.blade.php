<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Pintar - Face Recognition System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-figtree">

    <nav class="fixed w-full z-50 glass-effect border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10H9.01M15 10H15.01M20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z"></path></svg>
                    </div>
                    <span class="text-xl font-bold text-blue-900">HadirMas</span>
                </div>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-blue-700 transition shadow-md">Daftar Sekarang</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 hero-gradient text-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:flex items-center">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Absensi Modern dengan <br> <span class="text-blue-200">Face Recognition</span>
                    </h1>
                    <p class="text-xl mb-8 text-blue-50 opacity-90 leading-relaxed">
                        Tingkatkan kedisiplinan dan akurasi data kehadiran dengan teknologi pengenalan wajah berbasis AI. Cepat, aman, dan tanpa sentuh.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition text-center shadow-lg">
                            Mulai Sekarang
                        </a>
                        <a href="#fitur" class="border-2 border-white/30 bg-white/10 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/20 transition text-center backdrop-blur-sm">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 flex justify-center">
                    <div class="relative w-full max-w-lg">
                        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
                        <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
                        
                        <div class="relative bg-white/10 p-4 rounded-3xl border border-white/20 backdrop-blur-md shadow-2xl">
                             <div class="bg-gray-900 rounded-2xl aspect-video flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 border-2 border-blue-400 opacity-50 m-12 rounded-lg"></div>
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-blue-400 mx-auto mb-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    <p class="text-blue-300 text-sm font-mono tracking-widest">SCANNING FACE...</p>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-blue-600 font-bold tracking-wide uppercase">Fitur Unggulan</h2>
                <p class="mt-2 text-4xl font-extrabold text-gray-900">Segala kemudahan dalam satu platform</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition">
                        <svg class="w-8 h-8 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Face Recognition</h3>
                    <p class="text-gray-600">Teknologi AI yang memastikan absen tidak bisa dimanipulasi dan sangat cepat.</p>
                </div>

                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition">
                        <svg class="w-8 h-8 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Manajemen Izin</h3>
                    <p class="text-gray-600">Ajukan sakit, terlambat, atau izin tidak hadir lengkap dengan lampiran bukti dokumen.</p>
                </div>

                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition">
                        <svg class="w-8 h-8 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10m14 0v-4a2 2 0 012-2h2a2 2 0 012 2v4m0 0h-2a2 2 0 01-2-2v-4m-7 10h7m-7-5h7" stroke-width="2" stroke-linecap="round"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Laporan Admin</h3>
                    <p class="text-gray-600">Admin dapat memantau kehadiran Mahasiswa secara real-time dan mengelola data izin.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex justify-center gap-2 mb-4">
                 <div class="bg-blue-600 p-1 rounded">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10H9.01M15 10H15.01M20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z"></path></svg>
                </div>
                <span class="text-white font-bold">HadirMas</span>
            </div>
            <p>&copy; 2026 HadirMas System. Dibuat dengan Laravel 10 & Python.</p>
        </div>
    </footer>

</body>
</html>