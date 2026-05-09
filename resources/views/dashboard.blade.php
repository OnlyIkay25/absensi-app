<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    @php
        $hariIni = \Carbon\Carbon::now()->translatedFormat('l');
        $jadwalHariIni = [];

        if ($hariIni == 'Senin') {
            $jadwalHariIni[] = ['jam' => '19:30', 'mk' => 'Kriptografi', 'dosen' => 'Erick Harlest Budi Harjo', 'ruang' => 'Ruang Teori 1'];
        } elseif ($hariIni == 'Selasa') {
            $jadwalHariIni[] = ['jam' => '17:30', 'mk' => 'Virtual dan Augmented', 'dosen' => 'Muhammad Muharrom', 'ruang' => 'Lab Komputer'];
            $jadwalHariIni[] = ['jam' => '19:30', 'mk' => 'Proyek Teknologi Informasi', 'dosen' => 'Dr. Heri Kuswara', 'ruang' => 'Ruang 204'];
        } elseif ($hariIni == 'Rabu') {
            $jadwalHariIni[] = ['jam' => '17:30', 'mk' => 'Pengolah Citra', 'dosen' => 'Giatika Chrisnawati', 'ruang' => 'Lab Multimedia'];
            $jadwalHariIni[] = ['jam' => '19:30', 'mk' => 'Cloud Computering', 'dosen' => 'Hidayat Muhammad Nur', 'ruang' => 'Ruang 301'];
        } elseif ($hariIni == 'Kamis') {
            $jadwalHariIni[] = ['jam' => '17:30', 'mk' => 'Arsitektur Enterprise', 'dosen' => 'Rinawati', 'ruang' => 'Ruang 102'];
            $jadwalHariIni[] = ['jam' => '19:30', 'mk' => 'Internet Of Things', 'dosen' => 'Sigit Wibawa', 'ruang' => 'Lab Hardware'];
        }
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 shadow-lg text-white flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-blue-100 text-sm md:text-base">Ini adalah ringkasan data akademik dan absensi Anda semester ini. "Pendidikan adalah senjata paling mematikan di dunia."</p>
                </div>
                <a href="{{ route('jadwal.index') }}" class="shrink-0 bg-white text-blue-700 hover:bg-blue-50 font-bold py-3 px-6 rounded-xl shadow-md transition transform hover:-translate-y-1">
                    Mulai Absen Sekarang
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Total Hadir</p>
                        <p class="text-2xl font-extrabold text-gray-900">12 <span class="text-sm font-medium text-gray-400">Pertemuan</span></p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Izin / Sakit</p>
                        <p class="text-2xl font-extrabold text-gray-900">2 <span class="text-sm font-medium text-gray-400">Kali</span></p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Tanpa Keterangan</p>
                        <p class="text-2xl font-extrabold text-gray-900">0 <span class="text-sm font-medium text-gray-400">Kali</span></p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Persentase</p>
                        <p class="text-2xl font-extrabold text-blue-600">85.7<span class="text-lg font-bold">%</span></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                
                <div class="md:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h3 class="text-xl font-bold text-gray-900">Jadwal Kuliah Hari Ini 📅</h3>
                        <span class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">{{ $hariIni }}, {{ now()->translatedFormat('d M Y') }}</span>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($jadwalHariIni as $jadwal)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-blue-300 transition">
                                <div class="flex gap-4 items-center mb-4 sm:mb-0">
                                    <div class="bg-indigo-100 text-indigo-700 font-extrabold text-sm p-3 rounded-xl text-center min-w-[70px]">
                                        {{ $jadwal['jam'] }}<br><span class="text-[10px] font-medium text-indigo-500">WIB</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-lg">{{ $jadwal['mk'] }}</h4>
                                        <p class="text-sm text-slate-500 mt-0.5">Dosen: {{ $jadwal['dosen'] }} | {{ $jadwal['ruang'] }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('jadwal.index') }}" class="text-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-sm transition">Absen Wajah</a>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                                <svg class="w-12 h-12 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-slate-600 font-medium">Hore! Tidak ada jadwal kuliah untuk hari ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Pengumuman 📢</h3>
                    <ul class="space-y-4">
                        <li class="flex gap-3">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-2 shrink-0"></div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Ujian Tengah Semester</p>
                                <p class="text-xs text-gray-500 mt-1">Jadwal UTS akan dimulai pada minggu depan. Pastikan persentase kehadiran Anda di atas 75%.</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <div class="w-2 h-2 rounded-full bg-amber-500 mt-2 shrink-0"></div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Libur Nasional</p>
                                <p class="text-xs text-gray-500 mt-1">Perkuliahan ditiadakan pada hari libur nasional. Jadwal pengganti menyusul.</p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>