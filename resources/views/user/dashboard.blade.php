<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ ...jamDigital(), profileLengkap: false }" x-init="initJam()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <div class="xl:col-span-2 space-y-8">
                    
                    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                        <div class="absolute -bottom-10 -right-10 text-white opacity-10 transform rotate-12">
                            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                        </div>
                        
                        <div class="relative z-10 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div>
                                <p class="text-blue-200 font-medium text-lg mb-1 tracking-wide" x-text="sapaan"></p>
                                <h3 class="text-3xl sm:text-4xl font-extrabold mb-3">{{ Auth::user()->name }}</h3>
                                <p class="max-w-lg text-blue-100 text-base leading-relaxed opacity-90">
                                    Jadwal kuliahmu hari ini sudah siap. Pastikan pencahayaan ruangan cukup baik saat melakukan presensi dengan Face Recognition.
                                </p>
                            </div>
                            <div class="shrink-0">
                                <button @click.prevent="profileLengkap ? window.location.href='{{ route('absen.index') }}' : window.location.href='{{ route('profile.edit') }}'" 
                                        class="inline-flex items-center justify-center bg-white text-blue-700 font-bold px-6 py-3.5 rounded-xl shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(255,255,255,0.5)] transition-all transform hover:-translate-y-1 gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Mulai Presensi
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition flex items-center gap-4">
                            <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-semibold mb-1">Kehadiran</p>
                                <h4 class="text-2xl font-extrabold text-gray-900">24 <span class="text-sm font-medium text-gray-400">Sesi</span></h4>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition flex items-center gap-4">
                            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-semibold mb-1">Izin/Sakit</p>
                                <h4 class="text-2xl font-extrabold text-gray-900">2 <span class="text-sm font-medium text-gray-400">Sesi</span></h4>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition flex items-center gap-4">
                            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-semibold mb-1">Alfa / Bolos</p>
                                <h4 class="text-2xl font-extrabold text-gray-900">0 <span class="text-sm font-medium text-gray-400">Sesi</span></h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-xl font-extrabold text-gray-900">Aktivitas Terkini</h4>
                            <a href="{{ route('history.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded-lg transition">Lihat Riwayat</a>
                        </div>
                        
                        <div class="relative pl-4 space-y-8 before:absolute before:inset-y-0 before:left-[19px] before:w-[2px] before:bg-gray-100">
                            <div class="relative flex gap-6 items-start">
                                <div class="w-2 h-2 mt-2 rounded-full bg-emerald-500 ring-4 ring-emerald-50 z-10 relative left-0.5"></div>
                                <div>
                                    <h5 class="font-bold text-gray-900">Presensi Berhasil - Rekayasa Perangkat Lunak</h5>
                                    <p class="text-sm text-gray-500 mt-1">Hari ini, 08:15 WIB via Face Recognition</p>
                                </div>
                            </div>
                            <div class="relative flex gap-6 items-start">
                                <div class="w-2 h-2 mt-2 rounded-full bg-amber-500 ring-4 ring-amber-50 z-10 relative left-0.5"></div>
                                <div>
                                    <h5 class="font-bold text-gray-900">Pengajuan Izin Disetujui (Sakit)</h5>
                                    <p class="text-sm text-gray-500 mt-1">Kemarin, 14:30 WIB - Sistem Basis Data</p>
                                </div>
                            </div>
                            <div class="relative flex gap-6 items-start">
                                <div class="w-2 h-2 mt-2 rounded-full bg-blue-500 ring-4 ring-blue-50 z-10 relative left-0.5"></div>
                                <div>
                                    <h5 class="font-bold text-gray-900">Pendaftaran Akun Berhasil</h5>
                                    <p class="text-sm text-gray-500 mt-1">26 April 2026, 10:00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="space-y-8">
                    
                    <div class="bg-gray-900 rounded-3xl p-8 text-center shadow-lg relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-400 via-transparent to-transparent"></div>
                        <div class="relative z-10 text-white">
                            <p class="text-gray-400 font-semibold mb-2 uppercase tracking-widest text-sm" x-text="tanggal"></p>
                            <h2 class="text-5xl font-mono font-bold tracking-tight text-blue-400" x-text="waktu"></h2>
                            <p class="text-gray-500 text-xs mt-2 font-mono" x-text="zonaWaktu"></p>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8">
                        <div class="flex items-start justify-between mb-2">
                            <div class="bg-indigo-100 text-indigo-600 p-2.5 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-sm font-extrabold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">40%</span>
                        </div>
                        <h4 class="font-bold text-gray-900 mt-4 mb-2">Lengkapi Profil Anda</h4>
                        <p class="text-sm text-gray-500 mb-5">Data keluarga (Nama Ibu Kandung, Pekerjaan, dll) belum diisi. Lengkapi sekarang untuk keperluan administrasi.</p>
                        
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-5 overflow-hidden">
                            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 40%"></div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="block w-full py-3 text-center text-sm font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                            Lengkapi Data Sekarang
                        </a>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            <h4 class="text-lg font-bold text-gray-900">Papan Pengumuman</h4>
                        </div>
                        <div class="p-4 rounded-2xl bg-yellow-50 border border-yellow-100">
                            <span class="text-xs font-bold text-yellow-800 uppercase tracking-wider">Perhatian</span>
                            <p class="text-sm text-gray-700 mt-2 font-medium leading-relaxed">
                                Fitur absensi wajah hanya dapat dilakukan pada radius 100 meter dari area kampus. Jika Anda sakit, harap unggah surat dokter di menu Pengajuan Izin.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('jamDigital', () => ({
                waktu: '00:00:00',
                tanggal: '',
                zonaWaktu: '',
                sapaan: '',
                
                initJam() {
                    this.updateJam();
                    setInterval(() => this.updateJam(), 1000);
                },

                updateJam() {
                    const now = new Date();
                    
                    // Format Jam
                    this.waktu = now.toLocaleTimeString('id-ID', { hour12: false });
                    
                    // Format Tanggal
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    this.tanggal = now.toLocaleDateString('id-ID', options);

                    // Ambil Zona Waktu
                    const timeString = now.toLocaleTimeString('en-US', {timeZoneName:'short'});
                    this.zonaWaktu = timeString.split(' ')[2] || 'WIB';

                    // Sapaan Berdasarkan Jam
                    const jam = now.getHours();
                    if (jam < 11) this.sapaan = 'Selamat Pagi,';
                    else if (jam < 15) this.sapaan = 'Selamat Siang,';
                    else if (jam < 18) this.sapaan = 'Selamat Sore,';
                    else this.sapaan = 'Selamat Malam,';
                }
            }))
        })
    </script>
</x-app-layout>