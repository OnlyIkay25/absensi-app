<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Kuliah') }}
        </h2>
    </x-slot>

    @php
        $hariIni = \Carbon\Carbon::now()->translatedFormat('l');
        $jamIni = \Carbon\Carbon::now()->format('H:i');
        
        $mkHariIni = 'Tidak Ada Jadwal';
        $dosenHariIni = '-';
        $waktuHariIni = '-';

        if ($hariIni == 'Senin') {
            $mkHariIni = 'Kriptografi'; $dosenHariIni = 'Erick Harlest Budi Harjo'; $waktuHariIni = '19:30 - 21:30 WIB';
        } elseif ($hariIni == 'Selasa') {
            if ($jamIni < '19:00') { $mkHariIni = 'Virtual dan Augmented'; $dosenHariIni = 'Muhammad Muharrom'; $waktuHariIni = '17:30 - 19:30 WIB'; } 
            else { $mkHariIni = 'Proyek Teknologi Informasi'; $dosenHariIni = 'Dr. Heri Kuswara'; $waktuHariIni = '19:30 - 21:30 WIB'; }
        } elseif ($hariIni == 'Rabu') {
            if ($jamIni < '19:00') { $mkHariIni = 'Pengolah Citra'; $dosenHariIni = 'Giatika Chrisnawati'; $waktuHariIni = '17:30 - 19:30 WIB'; } 
            else { $mkHariIni = 'Cloud Computering'; $dosenHariIni = 'Hidayat Muhammad Nur'; $waktuHariIni = '19:30 - 21:30 WIB'; }
        } elseif ($hariIni == 'Kamis') {
            if ($jamIni < '19:00') { $mkHariIni = 'Arsitektur Enterprise'; $dosenHariIni = 'Rinawati'; $waktuHariIni = '17:30 - 19:30 WIB'; } 
            else { $mkHariIni = 'Internet Of Things'; $dosenHariIni = 'Sigit Wibawa'; $waktuHariIni = '19:30 - 21:30 WIB'; }
        } else {
            // Jika hari Jumat, Sabtu, Minggu (Untuk Mancing)
            $mkHariIni = 'Mata Kuliah Pengganti / Ekstra'; $dosenHariIni = 'Dosen Pengampu'; $waktuHariIni = 'Menyesuaikan';
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
                            <video id="webcam" autoplay playsinline class="absolute inset-0 w-full h-full object-cover"></video>
                            <canvas id="canvas" class="hidden"></canvas>
                            
                            <div class="absolute inset-8 border-2 border-dashed border-white/50 rounded-3xl pointer-events-none"></div>

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
                                <div class="flex items-center text-sm text-gray-500 gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $waktuHariIni }}
                                </div>
                                <div class="flex items-center text-sm text-gray-500 gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Dosen: {{ $dosenHariIni }}
                                </div>
                            </div>
                        </div>

                        <button id="btn-absen" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-base shadow-lg shadow-blue-200 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Kirim Kehadiran
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const btnAbsen = document.getElementById('btn-absen');
        const statusText = document.getElementById('status-face');

        // Nyalakan kamera HANYA jika mahasiswa punya face_embedding
        @if(Auth::user()->face_embedding)
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => { video.srcObject = stream; })
                .catch(err => { statusText.innerHTML = "❌ Gagal akses kamera"; });
        @endif

        btnAbsen.onclick = async () => {
            const canvas = document.getElementById('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            const image = canvas.toDataURL('image/jpeg');

            statusText.innerHTML = "Mencocokkan wajah... ⏳";
            btnAbsen.disabled = true;

            try {
                const res = await fetch("{{ route('absen.store') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ image })
                });
                const data = await res.json();

                if(data.status === 'success') {
                    statusText.innerHTML = "✅ Absen Berhasil!";
                    // Lari ke riwayat setelah 2 detik
                    setTimeout(() => window.location.href = "{{ route('history.index') }}", 2000);
                } else {
                    statusText.innerHTML = "❌ " + data.message;
                    btnAbsen.disabled = false;
                }
            } catch (e) {
                statusText.innerHTML = "❌ Mesin AI Mati.";
                btnAbsen.disabled = false;
            }
        };
    </script>
</x-app-layout>