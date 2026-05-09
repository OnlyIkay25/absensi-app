<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Profil & Data Diri') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- ALERT KUNING: Muncul jika mahasiswa belum rekam wajah -->
            @if(!Auth::user()->face_embedding)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-yellow-800">Aksi Diperlukan</h3>
                        <p class="mt-1 text-sm text-yellow-700">
                            Anda belum melengkapi profil atau mendaftarkan wajah. Fitur presensi tidak dapat digunakan sebelum data di bawah ini dilengkapi.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- DUA KOLOM -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- KOLOM KIRI: REGISTRASI WAJAH AI -->
                <div class="md:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">1. Registrasi Wajah</h3>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">Pindai wajah Anda sebagai data referensi awal (Encoding) untuk sistem Face Recognition.</p>
                    
                    <!-- Kotak Kamera -->
                    <div class="relative w-full aspect-[3/4] bg-gray-200 rounded-xl overflow-hidden mb-5 flex items-center justify-center border-4 border-slate-50">
                        <video id="webcam" autoplay playsinline class="w-full h-full object-cover"></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        
                        <!-- Garis Panduan Wajah (Overlay) -->
                        <div class="absolute inset-6 border-2 border-dashed border-blue-400/60 rounded-[3rem] pointer-events-none"></div>
                    </div>

                    <button id="btn-save-face" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold flex justify-center items-center gap-2 transition-all shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Ambil & Simpan Wajah
                    </button>
                    
                    <p id="status-face" class="mt-4 text-sm font-bold text-center h-5"></p>
                </div>

                <!-- KOLOM KANAN: FORM DATA DIRI -->
                <div class="md:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">2. Kelengkapan Data Diri</h3>

                    @if (session('status') === 'Profil berhasil diperbarui!')
                        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 font-medium text-sm rounded-r-lg">
                            ✅ Data diri berhasil disimpan ke dalam sistem.
                        </div>
                    @endif
                    
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Induk Mahasiswa (NIM)</label>
                            <input type="text" name="nim" value="{{ old('nim', Auth::user()->nim ?? '') }}" class="w-full rounded-lg border-gray-300 bg-blue-50/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5" placeholder="Masukkan NIM Anda">
                            <p class="mt-1.5 text-xs text-gray-500 font-medium">NIM tidak dapat diubah setelah disimpan.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Kota Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', Auth::user()->tempat_lahir ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5" placeholder="Isi Kota Lahir">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', Auth::user()->tanggal_lahir ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Domisili</label>
                            <textarea name="alamat" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Alamat lengkap...">{{ old('alamat', Auth::user()->alamat ?? '') }}</textarea>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit" class="px-8 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold transition shadow-md">
                                Simpan Data Diri
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT MESIN AI UNTUK REGISTRASI WAJAH -->
    <script>
        const video = document.getElementById('webcam');
        const statusText = document.getElementById('status-face');
        const btnSaveFace = document.getElementById('btn-save-face');

        // Otomatis nyalakan kamera saat halaman dimuat
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => { video.srcObject = stream; })
            .catch(err => { 
                statusText.innerHTML = "<span class='text-rose-600'>❌ Izin kamera ditolak.</span>"; 
            });

        // Proses saat tombol Ambil Wajah diklik
        btnSaveFace.onclick = async () => {
            const canvas = document.getElementById('canvas');
            canvas.width = video.videoWidth; 
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            
            const image = canvas.toDataURL('image/jpeg');

            statusText.innerHTML = "<span class='text-amber-500 animate-pulse'>Mendaftarkan wajah ke AI... ⏳</span>";
            btnSaveFace.disabled = true;
            btnSaveFace.classList.add('opacity-50');
            
            try {
                // Tembak ke endpoint ProfileController kita
                const res = await fetch("{{ route('profile.face') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ image })
                });

                const data = await res.json();
                
                if(data.status === 'success') {
                    statusText.innerHTML = "<span class='text-emerald-600'>✅ Sandi Wajah Tersimpan!</span>";
                    btnSaveFace.innerHTML = "Wajah Terdaftar ✔️";
                    btnSaveFace.classList.replace('bg-blue-600', 'bg-emerald-500');
                    btnSaveFace.classList.replace('hover:bg-blue-700', 'hover:bg-emerald-600');
                    
                    // Kalau mau otomatis pindah ke Jadwal, hapus tanda // di bawah ini:
                    // setTimeout(() => window.location.href = "{{ route('jadwal.index') }}", 1500);
                } else {
                    statusText.innerHTML = "<span class='text-rose-600'>❌ " + data.message + "</span>";
                    btnSaveFace.disabled = false;
                    btnSaveFace.classList.remove('opacity-50');
                }
            } catch (error) {
                statusText.innerHTML = "<span class='text-rose-600'>❌ Gagal terhubung ke server.</span>";
                btnSaveFace.disabled = false;
                btnSaveFace.classList.remove('opacity-50');
            }
        };
    </script>
</x-app-layout>