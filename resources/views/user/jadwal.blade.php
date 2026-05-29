<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Kuliah') }}
        </h2>
    </x-slot>

    @php
        $userId = Auth::id();
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
            $jadwalHariIni[] = ['jam' => '17:30', 'jam_selesai' => '21:30', 'mk' => 'Arsitektur Enterprise', 'dosen' => 'Rinawati', 'ruang' => 'Ruang 301'];
            $jadwalHariIni[] = ['jam' => '19:30', 'jam_selesai' => '21:30', 'mk' => 'Internet Of Things', 'dosen' => 'Sigit Wibawa', 'ruang' => 'Ruang 301'];
        }

        $mkRequest = request('mk');
        $jadwalAktif = null;

        if ($mkRequest) {
            foreach ($jadwalHariIni as $j) {
                if ($j['mk'] == $mkRequest) {
                    $jadwalAktif = $j; break;
                }
            }
        }

        if (!$jadwalAktif && count($jadwalHariIni) > 0) {
            foreach ($jadwalHariIni as $j) {
                if ($jamIni <= $j['jam_selesai']) {
                    $jadwalAktif = $j; break;
                }
            }
            if (!$jadwalAktif) $jadwalAktif = end($jadwalHariIni);
        }

        $mkHariIni = $jadwalAktif ? $jadwalAktif['mk'] : 'Tidak Ada Jadwal';
        $dosenHariIni = $jadwalAktif ? $jadwalAktif['dosen'] : '-';
        $waktuHariIni = $jadwalAktif ? $jadwalAktif['jam'] . ' - ' . $jadwalAktif['jam_selesai'] . ' WIB' : '-';
        $jamMulaiStr = $jadwalAktif ? $jadwalAktif['jam'] : '00:00';
        $jamSelesaiStr = $jadwalAktif ? $jadwalAktif['jam_selesai'] : '00:00';

        $adaJadwal = ($mkHariIni != 'Tidak Ada Jadwal');
        $sudahAbsen = false;
        $belumMulai = false;
        $waktuHabis = false;
        $statusTerlambat = false;

        if ($adaJadwal) {
            $jamMulai = \Carbon\Carbon::createFromFormat('H:i', $jamMulaiStr);
            $jamSelesai = \Carbon\Carbon::createFromFormat('H:i', $jamSelesaiStr);
            $batasTelat = $jamMulai->copy()->addMinutes(15);

            $sudahAbsen = \App\Models\Absensi::where('user_id', $userId)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->where('mata_kuliah', $mkHariIni)
                            ->exists();
                            
            $belumMulai = $waktuSekarang->lessThan($jamMulai);
            $waktuHabis = $waktuSekarang->greaterThan($jamSelesai);
            $statusTerlambat = $waktuSekarang->between($batasTelat, $jamSelesai);
        }
    @endphp

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">Jadwal Kuliah Hari Ini</h3>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 relative overflow-hidden">
                
                @if(!Auth::user()->face_embedding)
                <div class="absolute inset-0 bg-white/70 backdrop-blur-sm z-20 flex flex-col items-center justify-center p-6 text-center">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border border-amber-100 max-w-md w-full">
                        <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-amber-100">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900 mb-2">Akses Kamera Terkunci</h3>
                        <p class="text-gray-500 text-sm mb-6">Anda belum mendaftarkan data wajah. Fitur presensi AI tidak dapat digunakan sebelum wajah Anda terdaftar di sistem.</p>
                        <a href="{{ route('profile.edit') }}" class="inline-block w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md">
                            Daftarkan Wajah Sekarang
                        </a>
                    </div>
                </div>
                @endif

                <h4 class="text-2xl font-bold text-gray-900 mb-6">Jadwal Kuliah Hari Ini</h4>

                <div class="flex flex-col md:flex-row gap-8 items-stretch">
                    
                    <div class="w-full md:w-3/5">
                        <div class="relative bg-gray-200 rounded-3xl overflow-hidden aspect-video border border-gray-100 flex flex-col justify-end shadow-inner">
                            <video id="webcam" autoplay playsinline class="absolute inset-0 w-full h-full object-cover transform scale-x-[-1]"></video>
                            <canvas id="canvas" class="hidden"></canvas>
                            
                            <div class="absolute inset-8 border-2 border-dashed border-white/50 rounded-3xl pointer-events-none flex items-center justify-center">
                                <div class="w-32 h-32 border border-white/30 rounded-full"></div>
                            </div>

                            <div class="relative z-10 bg-black/60 backdrop-blur-md py-3 text-center w-full mt-auto">
                                <p id="status-face" class="text-white text-sm font-bold tracking-wide flex items-center justify-center gap-2">
                                    Kamera Siap... <span class="animate-pulse">🔍</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-2/5 flex flex-col justify-between space-y-6">
                        
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex-1">
                            <div class="flex items-start gap-4 mb-5">
                                <div class="bg-blue-600 text-white p-3 rounded-2xl shadow-md shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg leading-tight mb-1">{{ $mkHariIni }}</h4>
                                    <p class="text-[10px] text-blue-600 font-extrabold uppercase tracking-wider">Mata Kuliah Utama</p>
                                </div>
                            </div>
                            
                            <div class="space-y-3 pt-4 border-t border-gray-50">
                                <div class="flex items-center text-sm text-gray-500 gap-3 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $waktuHariIni }}
                                </div>
                                <div class="flex items-center text-sm text-gray-500 gap-3 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Dosen: {{ $dosenHariIni }}
                                </div>
                            </div>
                        </div>

                        <div>
                            @if(!$adaJadwal)
                                <button disabled class="w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold text-sm cursor-not-allowed border border-slate-200">TIDAK ADA JADWAL HARI INI</button>
                            @elseif(!Auth::user()->face_embedding)
                                <button disabled class="w-full py-4 bg-slate-200 text-slate-400 rounded-2xl font-bold text-sm cursor-not-allowed">KUNCI WAJAH</button>
                            @elseif($sudahAbsen)
                                <button disabled class="w-full py-4 bg-emerald-50 text-emerald-600 rounded-2xl font-bold text-sm cursor-not-allowed border border-emerald-200">SUDAH ABSEN HARI INI</button>
                            @elseif($waktuHabis)
                                <button disabled class="w-full py-4 bg-rose-50 text-rose-500 rounded-2xl font-bold text-sm cursor-not-allowed border border-rose-200">WAKTU ABSEN HABIS</button>
                            @elseif($belumMulai)
                                <button disabled class="w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold text-sm cursor-not-allowed border border-slate-200">⏳ KELAS BELUM DIMULAI</button>
                            @else
                                <button id="btn-absen" class="w-full py-4 {{ $statusTerlambat ? 'bg-amber-500 hover:bg-amber-600 shadow-amber-200' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' }} text-white rounded-2xl font-bold text-base shadow-lg transition active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                    {{ $statusTerlambat ? 'KIRIM KEHADIRAN (TERLAMBAT)' : 'Kirim Kehadiran' }}
                                </button>
                                @if($statusTerlambat)
                                    <p class="text-center text-[10px] font-bold text-amber-500 mt-2 animate-pulse">⚠️ Melewati batas waktu 15 menit</p>
                                @endif
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const btnAbsen = document.getElementById('btn-absen');
        const statusText = document.getElementById('status-face');

        @if(Auth::user()->face_embedding && !$sudahAbsen && !$waktuHabis && !$belumMulai && $adaJadwal)
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => { video.srcObject = stream; })
                .catch(err => { statusText.innerHTML = "❌ Gagal akses kamera"; });
        @else
            if(statusText) statusText.innerHTML = "Kamera Nonaktif";
        @endif

        if(btnAbsen) {
            btnAbsen.onclick = () => {
                // 1. Cek Dukungan GPS
                if (!navigator.geolocation) {
                    statusText.innerHTML = "❌ Browser tidak mendukung GPS.";
                    return;
                }

                statusText.innerHTML = "Mencari lokasi Anda... 📍";
                btnAbsen.disabled = true;
                btnAbsen.innerHTML = "Tunggu...";

                // 2. Dapatkan Lokasi (Geofencing)
                navigator.geolocation.getCurrentPosition(async function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // 3. Tangkap Foto dari Video (di-mirror agar pas)
                    const canvas = document.getElementById('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    
                    const ctx = canvas.getContext('2d');
                    ctx.translate(canvas.width, 0);
                    ctx.scale(-1, 1);
                    ctx.drawImage(video, 0, 0);
                    
                    const image = canvas.toDataURL('image/jpeg');

                    statusText.innerHTML = "Mencocokkan wajah & lokasi... ⏳";

                    // 4. Kirim Data ke Laravel Backend
                    try {
                        const res = await fetch("{{ route('absen.store') }}", {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'Accept': 'application/json', // PENTING: Mencegah crash jika Laravel mengirim pesan Error!
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                            },
                            body: JSON.stringify({ 
                                image: image,
                                latitude: lat,
                                longitude: lon,
                                mata_kuliah: "{{ $mkHariIni }}",
                                status_presensi: "{{ $statusTerlambat ? 'Terlambat' : 'Hadir' }}"
                            })
                        });
                        
                        const data = await res.json();

                        if(res.ok && data.status === 'success') {
                            statusText.innerHTML = "✅ Absen Berhasil! Mengalihkan...";
                            
                            // Ubah tombol jadi hijau
                            btnAbsen.classList.replace('bg-blue-600', 'bg-emerald-500');
                            btnAbsen.classList.replace('bg-amber-500', 'bg-emerald-500');
                            btnAbsen.innerHTML = "Berhasil Diabsen!";
                            
                            setTimeout(() => {
                                window.location.replace("{{ url('/riwayat') }}");
                            }, 1200);
                        } else {
                            // Menangkap pesan error asli dari Laravel (Jarak jauh, Wajah beda, atau Database error)
                            statusText.innerHTML = "❌ " + (data.message || data.error || "Gagal absen.");
                            btnAbsen.disabled = false;
                            btnAbsen.innerHTML = "Coba Lagi";
                        }
                    } catch (e) {
                        statusText.innerHTML = "❌ Error Sistem: " + e.message;
                        btnAbsen.disabled = false;
                        btnAbsen.innerHTML = "Coba Lagi";
                    }
                }, function(error) {
                    statusText.innerHTML = "❌ Izin Lokasi (GPS) Ditolak!";
                    btnAbsen.disabled = false;
                    btnAbsen.innerHTML = "Coba Lagi";
                }, { enableHighAccuracy: true });
            };
        }
    </script>
</x-app-layout>