<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - HadirMas</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-figtree antialiased bg-gray-50 text-gray-900">

    <div class="flex min-h-screen">
        <div class="hidden lg:flex w-1/2 bg-blue-600 justify-center items-center p-12 relative overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-10" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
            
            <div class="text-white text-center z-10">
                <svg class="w-48 h-48 mx-auto mb-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 10H9.01M15 10H15.01M20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17 14C17 14 15.5 16 12 16C8.5 16 7 14 7 14" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h1 class="text-4xl font-extrabold mb-4">Hadirmas</h1>
                <p class="text-xl opacity-90 max-w-md mx-auto">Selamat Datang! Silakan masuk untuk mengakses fitur pengenalan wajah dan manajemen kehadiran Anda.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex justify-center items-center p-8 md:p-12 relative">
            
            <a href="{{ url('/') }}" class="absolute top-8 right-8 text-gray-500 hover:text-blue-600 transition flex items-center gap-2 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Halaman Utama
            </a>

            <div class="w-full max-w-md p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
                <div class="mb-10 text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Masuk ke Akun</h2>
                    <p class="text-gray-500">Gunakan email dan kata sandi Anda</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <x-text-input id="email" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                        <x-text-input id="password" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mb-8 flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ml-2 text-sm text-gray-600 font-medium">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-800 font-bold transition" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 rounded-xl shadow-lg text-lg font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                            Masuk Sekarang
                        </button>
                    </div>

                    <div class="text-center mt-8 pt-6 border-t border-gray-100">
                        <p class="text-gray-600">Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>