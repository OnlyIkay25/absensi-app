<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar Akun - HadirMas</title>

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
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
                    Mulai perjalanan <br/> kedisiplinan Anda.
                </h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Sistem absensi berbasis pengenalan wajah yang didesain untuk kecepatan, akurasi, dan kenyamanan manajemen kehadiran modern.
                </p>
            </div>

            <div class="relative z-10 text-blue-200 text-sm font-medium">
                &copy; {{ date('Y') }} HadirMas System. All rights reserved.
            </div>
        </div>

        <div class="w-full lg:w-7/12 flex flex-col justify-center items-center p-6 sm:p-12 relative overflow-y-auto bg-gray-50">
            
            <a href="{{ url('/') }}" class="absolute top-6 right-6 lg:top-10 lg:right-10 text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-2 font-bold bg-white px-5 py-2.5 rounded-full shadow-sm hover:shadow-md border border-gray-200 z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>

            <div class="w-full max-w-2xl my-8">
                
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-3">Buat Akun Baru</h2>
                    <p class="text-gray-500 font-medium">Lengkapi informasi di bawah ini untuk mendaftarkan profil Anda.</p>
                </div>

                <div class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-xl border border-gray-100">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Misal: Budi Santoso" 
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-bold text-gray-700 mb-2">Kota Lahir</label>
                                <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Misal: Jakarta" 
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2 text-red-500" />
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir</label>
                                <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required 
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2 text-red-500" />
                            </div>
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-bold text-gray-700 mb-2">Alamat Domisili</label>
                            <textarea id="alamat" name="alamat" rows="2" required placeholder="Tuliskan alamat lengkap saat ini..." 
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4 resize-none">{{ old('alamat') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2 text-red-500" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" 
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                            </div>
                            <div>
                                <label for="no_hp" class="block text-sm font-bold text-gray-700 mb-2">Nomor Handphone</label>
                                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx" 
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                                <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-red-500" />
                            </div>
                        </div>

                        <div class="pt-2 pb-2">
                            <hr class="border-gray-200">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-2">
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Ulangi Kata Sandi</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang sandi"
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 py-3 px-4">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                            </div>
                        </div>

                        <button type="submit" class="w-full relative flex justify-center py-4 px-4 border border-transparent text-lg font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Daftarkan Akun
                        </button>

                    </form>
                </div>

                <div class="text-center mt-8">
                    <p class="text-gray-500 font-medium">
                        Sudah memiliki akun? 
                        <a href="{{ route('login') }}" class="font-extrabold text-blue-600 hover:text-blue-800 transition-colors ml-1">Masuk ke sistem</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>