<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $userId = Auth::id();
        $user = Auth::user();
        
        // Logika Pengambilan Data Real-Time
        $totalHadir = \App\Models\Absensi::where('user_id', $userId)->where('status', 'Hadir')->count();
        $totalIzin = \App\Models\Absensi::where('user_id', $userId)->whereIn('status', ['Izin', 'Sakit'])->count();
        $totalAlpa = \App\Models\Absensi::where('user_id', $userId)->where('status', 'Alpa')->count();
        
        $targetPertemuan = 14; 
        $persen = $targetPertemuan > 0 ? ($totalHadir / $targetPertemuan) * 100 : 0;
        
        $sudahVerifikasiWajah = !empty($user->face_embedding); 

        // Ambil Daftar MATA KULIAH yang sudah diabsen hari ini
        $absenHariIni = \App\Models\Absensi::where('user_id', $userId)
                                ->whereDate('created_at', \Carbon\Carbon::today())
                                ->pluck('mata_kuliah')
                                ->toArray();

        $hariIni = \Carbon\Carbon::now()->translatedFormat('l');
        $waktuSekarang = \Carbon\Carbon::now(); 
        $jamIni = $waktuSekarang->format('H:i');
        
        $jadwalHariIni = [];
        
        if ($hariIni == 'Senin') {
            $jadwalHariIni[] = ['jam' => '19:30', 'jam_selesai' => '21:30', 'mk' => 'Kriptografi', 'dosen' => 'Erick Harlest Budi Harjo', 'ruang' => 'Ruang 401'];
        } elseif ($hariIni == 'Selasa') {
            $jadwalHariIni[] = ['jam' => '17:30', 'jam_selesai' => '19:30', 'mk' => 'Virtual dan Augmented Reality', 'dosen' => 'Muhammad Muharrom', 'ruang' => 'Ruang 302'];
            $jadwalHariIni[] = ['jam' => '19:30', 'jam_selesai' => '21:30', 'mk' => 'Proyek Teknologi Informasi', 'dosen' => 'Dr. Heri Kuswara', 'ruang' => 'Ruang 302'];
        } elseif ($hariIni == 'Rabu') {
            $jadwalHariIni[] = ['jam' => '17:30', 'jam_selesai' => '19:30', 'mk' => 'Pengolah Citra', 'dosen' => 'Giatika Chrisnawati', 'ruang' => 'Ruang 304'];
            $jadwalHariIni[] = ['jam' => '19:30', 'jam_selesai' => '21:30', 'mk' => 'Cloud Computering', 'dosen' => 'Hidayatullah', 'ruang' => '304'];
        } elseif ($hariIni == 'Kamis') {
            $jadwalHariIni[] = ['jam' => '17:30', 'jam_selesai' => '19:30', 'mk' => 'Arsitektur Enterprise', 'dosen' => 'Rinawati', 'ruang' => 'Ruang 301'];
            $jadwalHariIni[] = ['jam' => '19:30', 'jam_selesai' => '21:30', 'mk' => 'Internet Of Things', 'dosen' => 'Sigit Wibawa', 'ruang' => 'Ruang 301'];
        }

        // PERBAIKAN LOGIKA: Memastikan urutan jadwal dicek dengan benar
    $mkAktifBanner = null;
    $sekarang = \Carbon\Carbon::now();

    foreach ($jadwalHariIni as $j) {
        $jamMulai = \Carbon\Carbon::createFromFormat('H:i', $j['jam']);
        $jamSelesai = \Carbon\Carbon::createFromFormat('H:i', $j['jam_selesai']);

        // Logika: Jika waktu sekarang berada di antara jam mulai dan jam selesai MK tersebut
        if ($sekarang->between($jamMulai, $jamSelesai)) {
            $mkAktifBanner = $j['mk'];
            break; // Berhenti mencari jika sudah ketemu yang sedang aktif
        }
    }
        
        // Buat Link Pintas Dinamis ke Jadwal sesuai jam
        $linkBanner = $mkAktifBanner ? url('/jadwal-kuliah') . '?mk=' . urlencode($mkAktifBanner) : url('/jadwal-kuliah');
@endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Dashboard Mahasiswa</h3>
            
            <div class="bg-blue-600 rounded-3xl p-8 mb-8 text-white flex flex-col md:flex-row justify-between items-center shadow-lg shadow-blue-200 gap-6">
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-blue-100 opacity-90 text-sm">Ini adalah ringkasan data akademik dan absensi Anda semester ini. "Pendidikan adalah senjata paling mematikan di dunia."</p>
                </div>
                <a href="{{ $linkBanner }}" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-md whitespace-nowrap">
                    Mulai Absen Sekarang
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="bg-emerald-100 p-3 rounded-xl text-emerald-600"><i class="fas fa-check-circle text-xl"></i></div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Total Hadir</p>
                        <p class="text-xl font-black text-slate-900">{{ $totalHadir }} <span class="text-xs font-medium text-slate-400">Pertemuan</span></p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="bg-amber-100 p-3 rounded-xl text-amber-600"><i class="fas fa-info-circle text-xl"></i></div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Izin / Sakit</p>
                        <p class="text-xl font-black text-slate-900">{{ $totalIzin }} <span class="text-xs font-medium text-slate-400">Kali</span></p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="bg-rose-100 p-3 rounded-xl text-rose-600"><i class="fas fa-times-circle text-xl"></i></div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Tanpa Keterangan</p>
                        <p class="text-xl font-black text-slate-900">{{ $totalAlpa }} <span class="text-xs font-medium text-slate-400">Kali</span></p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl text-blue-600"><i class="fas fa-chart-pie text-xl"></i></div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Persentase</p>
                        <p class="text-xl font-black text-slate-900">{{ number_format($persen, 1) }}%</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-bold text-slate-800">Jadwal Kuliah Hari Ini 📅</h4>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">{{ $hariIni }}, {{ date('d M Y') }}</span>
                        </div>

                        <div class="space-y-4">
                            @forelse($jadwalHariIni as $j)
                                @php
                                    $jamMulai = \Carbon\Carbon::createFromFormat('H:i', $j['jam']);
                                    $jamSelesai = \Carbon\Carbon::createFromFormat('H:i', $j['jam_selesai']);
                                    $batasTelat = $jamMulai->copy()->addMinutes(15);
                                    
                                    // Cek apakah MK spesifik ini sudah diabsen
                                    $sudahAbsenMKIni = in_array($j['mk'], $absenHariIni);

                                    $belumMulai = $waktuSekarang->lessThan($jamMulai); 
                                    $waktuHabis = $waktuSekarang->greaterThan($jamSelesai);
                                    $statusTerlambat = $waktuSekarang->between($batasTelat, $jamSelesai);
                                @endphp

                                <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-blue-100 text-blue-600 px-3 py-2 rounded-lg font-bold text-sm">{{ $j['jam'] }}</div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-lg leading-tight mb-1">{{ $j['mk'] }}</p>
                                            <p class="text-xs text-slate-500 font-medium">Dosen: {{ $j['dosen'] }} | {{ $j['ruang'] }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        @if(!$sudahVerifikasiWajah)
                                            <button disabled class="bg-slate-200 text-slate-400 px-4 py-2 rounded-xl text-xs font-bold cursor-not-allowed uppercase">LOCKED</button>
                                        @elseif($sudahAbsenMKIni)
                                            <button disabled class="bg-emerald-100 text-emerald-600 border border-emerald-200 px-4 py-2 rounded-xl text-xs font-bold cursor-not-allowed uppercase">SUDAH ABSEN</button>
                                        @elseif($waktuHabis)
                                            <button disabled class="bg-slate-200 text-slate-500 px-4 py-2 rounded-xl text-xs font-bold cursor-not-allowed uppercase">WAKTU HABIS</button>
                                        @elseif($belumMulai)
                                            <button disabled class="bg-slate-200 text-slate-400 px-4 py-2 rounded-xl text-xs font-bold cursor-not-allowed border border-slate-300 uppercase">BELUM DIMULAI</button>
                                        @else
                                            <a href="{{ url('/jadwal-kuliah') }}?mk={{ urlencode($j['mk']) }}" class="inline-block text-center {{ $statusTerlambat ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-4 py-2 rounded-xl text-xs font-bold shadow-md transition uppercase">Absen Wajah</a>
                                            @if($statusTerlambat)
                                                <p class="text-[9px] font-bold text-amber-500 text-right mt-1">⚠️ TERLAMBAT</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-center py-6 text-slate-400 font-medium">Tidak ada jadwal kuliah hari ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span>Pengumuman</span> <i class="fas fa-bullhorn text-blue-600"></i>
                    </h4>
                    <ul class="space-y-6">
                        <li class="flex gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Ujian Tengah Semester</p>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Jadwal UTS akan dimulai minggu depan. Pastikan persentase kehadiran Anda aman.</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Libur Nasional</p>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Perkuliahan ditiadakan pada hari libur nasional. Jadwal pengganti menyusul.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>