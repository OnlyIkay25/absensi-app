<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HadirMas - Absensi Modern dengan Face Recognition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .scan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: rgba(34, 211, 238, 0.8);
            box-shadow: 0 0 15px rgba(34, 211, 238, 0.8);
            animation: scan 3s ease-in-out infinite;
        }

        @keyframes scan {
            0%, 100% { top: 10%; }
            50% { top: 90%; }
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .face-grid {
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="bg-white py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2">
            <div class="bg-blue-600 p-1.5 rounded-lg text-white">
                <i class="fas fa-h-square text-xl"></i>
            </div>
            <span class="text-xl font-bold tracking-tight text-slate-800">HadirMas</span>
        </div>
        <div class="flex items-center gap-6">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-blue-700 transition shadow-md shadow-blue-200">Daftar Sekarang</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <header class="hero-gradient text-white py-16 md:py-24 px-6 md:px-12 overflow-hidden relative">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div class="z-10">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                    Absensi Modern <br> dengan <span class="text-cyan-300">Face Recognition</span>
                </h1>
                <p class="text-lg text-blue-50 mb-10 max-w-lg leading-relaxed opacity-90">
                    Tingkatkan kedisiplinan dan akurasi data kehadiran dengan teknologi pengenalan wajah. Cepat, aman, dan tanpa sentuh.
                </p>
                <div class="flex flex-wrap gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 px-8 py-3.5 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg inline-block">Mulai Sekarang</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-blue-600 px-8 py-3.5 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg inline-block">Mulai Sekarang</a>
                    @endauth
                    <a href="#fitur" class="bg-transparent border-2 border-white/30 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-white/10 transition inline-block">Pelajari Fitur</a>
                </div>
            </div>

            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-3xl blur opacity-30 group-hover:opacity-50 transition"></div>
                <div class="relative bg-slate-900 aspect-video rounded-2xl overflow-hidden border border-white/10 shadow-2xl face-grid">
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <div class="w-48 h-48 border-2 border-dashed border-cyan-400/50 rounded-full flex items-center justify-center relative">
                            <div class="w-40 h-40 border-2 border-cyan-400 rounded-full flex items-center justify-center animate-pulse">
                                <i class="fas fa-user-check text-5xl text-cyan-400"></i>
                            </div>
                            <div class="scan-overlay"></div>
                        </div>
                        <div class="mt-8 text-center">
                            <span class="text-cyan-400 font-mono tracking-widest text-sm uppercase">Scanning Face...</span>
                            <div class="flex gap-1 justify-center mt-2">
                                <div class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-bounce"></div>
                                <div class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-bounce [animation-delay:0.2s]"></div>
                                <div class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-bounce [animation-delay:0.4s]"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute top-4 left-4 flex gap-2">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    </div>
                    <div class="absolute bottom-4 right-4 flex gap-4 text-[10px] text-cyan-400/60 font-mono">
                        <span>LAT: -6.2348</span>
                        <span>LNG: 106.9896</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="fitur" class="py-20 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-bold tracking-widest uppercase text-xs">Fitur Unggulan</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-4 text-slate-800">Segala kemudahan dalam satu platform</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="feature-card p-8 bg-white rounded-2xl border border-blue-100 transition duration-300">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 text-2xl">
                    <i class="fas fa-face-smile"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-slate-800">Face Recognition</h3>
                <p class="text-slate-600 leading-relaxed">
                    Teknologi Face Recognition yang memastikan absen tidak bisa dimanipulasi dan sangat cepat.
                </p>
            </div>

            <div class="feature-card p-8 bg-white rounded-2xl border border-green-100 transition duration-300">
                <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 mb-6 text-2xl">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-slate-800">Manajemen Izin</h3>
                <p class="text-slate-600 leading-relaxed">
                    Ajukan sakit, terlambat, atau izin tidak hadir lengkap dengan lampiran bukti dokumen.
                </p>
            </div>

            <div class="feature-card p-8 bg-white rounded-2xl border border-purple-100 transition duration-300">
                <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-6 text-2xl">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-slate-800">Laporan Admin</h3>
                <p class="text-slate-600 leading-relaxed">
                    Admin dapat memantau kehadiran Mahasiswa secara real-time dan mengelola data izin.
                </p>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-12 px-6 md:px-12">
        <div class="max-w-7xl mx-auto flex flex-col items-center">
            <div class="flex items-center gap-2 mb-6">
                <div class="bg-blue-600 p-1.5 rounded-lg text-white">
                    <i class="fas fa-h-square text-xl"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">HadirMas</span>
            </div>
            <p class="text-slate-400 text-sm text-center">
                © {{ date('Y') }} HadirMas System. Dibuat Oleh Ikrar Wira Buwana
            </p>
        </div>
    </footer>

</body>
</html>