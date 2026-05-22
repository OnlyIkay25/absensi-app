<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - HadirMas</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Animasi Keren untuk Background Kiri */
        .blob {
            position: absolute;
            filter: blur(60px);
            z-index: 0;
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
        }
        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -50px) scale(1.2); }
        }
        .blob-1 { top: -10%; left: -10%; width: 300px; height: 300px; background: #60a5fa; }
        .blob-2 { bottom: -10%; right: -10%; width: 400px; height: 400px; background: #3b82f6; animation-delay: -5s; }
        
        /* Glass Effect */
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 h-screen flex overflow-hidden">

    <div class="hidden lg:flex lg:w-1/2 relative bg-blue-700 overflow-hidden items-center justify-center">
        <div class="blob blob-1 rounded-full"></div>
        <div class="blob blob-2 rounded-full"></div>
        
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 30px 30px;"></div>

        <div class="relative z-10 w-full max-w-lg p-12 glass-panel rounded-3xl text-center text-white shadow-2xl transform hover:scale-[1.02] transition-transform duration-500">
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-8 backdrop-blur-sm border border-white/30">
                <i class="fas fa-expand text-4xl text-white"></i>
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-4">Sistem Presensi Dengan Face Recognition</h1>
            <p class="text-blue-100 text-lg leading-relaxed mb-8">
                Akses dashboard akademik Anda. Verifikasi wajah otomatis, cepat, dan aman tanpa antrean.
            </p>
            <div class="flex items-center justify-center gap-4 text-sm font-medium text-blue-200">
                <span class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-400"></i> Real-time</span>
                <span class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-400"></i> Anti-Spoofing</span>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative overflow-y-auto">
        
        <a href="{{ url('/') }}" class="absolute top-6 right-6 sm:top-8 sm:right-8 group flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition">
            <i class="fas fa-arrow-left transform group-hover:-translate-x-1 transition"></i> Halaman Utama
        </a>

        <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
            <div class="mb-10 text-center sm:text-left">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 text-blue-600 mb-6 lg:hidden">
                    <i class="fas fa-h-square text-2xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Selamat Datang</h2>
                <p class="text-slate-500">Silakan masukkan email dan kata sandi Anda.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                            class="block w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow bg-slate-50 focus:bg-white" 
                            placeholder="nama@gmail.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-sm" />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full pl-11 pr-12 py-3.5 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow bg-slate-50 focus:bg-white" 
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition">
                            <i id="eye-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500 text-sm" />
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition">
                    <label for="remember_me" class="ml-3 text-sm font-medium text-slate-600 cursor-pointer">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-300 transition-all duration-300 flex items-center justify-center gap-2">
                    Masuk Sekarang <i class="fas fa-arrow-right text-sm"></i>
                </button>

                <p class="text-center text-sm text-slate-600 mt-8 font-medium">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 hover:after:w-full after:transition-all after:duration-300">
                        Daftar di sini
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwdInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                eyeIcon.classList.add('text-blue-600');
            } else {
                pwdInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.remove('text-blue-600');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>