<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lupa Kata Sandi - HadirMas</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen">

    <div class="flex min-h-screen">
        
        <div class="hidden lg:flex lg:w-5/12 relative flex-col justify-between p-12 bg-blue-600 overflow-hidden sticky top-0 h-screen shadow-2xl z-10">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] rounded-full bg-blue-400/40 blur-3xl"></div>
                <div class="absolute bottom-[10%] -right-[20%] w-[60%] h-[60%] rounded-full bg-white/10 blur-3xl"></div>
            </div>

            <div class="relative z-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">Hadir<span class="text-blue-200">Mas</span></span>
            </div>

            <div class="relative z-10 my-auto pr-8">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
                    Jangan khawatir, <br/> kami bantu Anda.
                </h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Sistem keamanan kami akan memastikan Anda dapat kembali mengakses akun Anda dengan cepat dan aman melalui tautan verifikasi email.
                </p>
            </div>

            <div class="relative z-10 text-blue-200 text-sm font-medium">
                &copy; {{ date('Y') }} HadirMas System. All rights reserved.
            </div>
        </div>

        <div class="w-full lg:w-7/12 flex flex-col justify-center items-center p-6 sm:p-12 relative overflow-y-auto bg-gray-50">
            
            <a href="{{ route('login') }}" class="absolute top-6 right-6 lg:top-10 lg:right-10 text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-2 font-bold bg-white px-5 py-2.5 rounded-full shadow-sm hover:shadow-md border border-gray-200 z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden sm:inline">Kembali ke Login</span>
            </a>

            <div class="w-full max-w-md my-8">
                
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-3">Lupa Kata Sandi?</h2>
                    <p class="text-gray-500 font-medium leading-relaxed">
                        Tidak masalah. Beritahu kami alamat email Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-xl border border-gray-100">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email Terdaftar</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda" 
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full relative flex justify-center py-4 px-4 border border-transparent text-lg font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                Kirim Tautan Reset Sandi
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>