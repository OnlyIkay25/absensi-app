<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(!Auth::user()->face_embedding)
            <div class="bg-amber-50 border-l-4 border-amber-400 p-5 rounded-r-xl shadow-sm mb-6 flex items-start">
                <i class="fas fa-exclamation-triangle text-amber-500 text-xl mr-4 mt-0.5"></i>
                <div>
                    <h3 class="text-sm font-extrabold text-amber-800">Aksi Diperlukan</h3>
                    <p class="text-sm text-amber-700 mt-1">Anda belum melengkapi profil atau mendaftarkan wajah. Fitur presensi tidak dapat digunakan sebelum data wajah Anda tersimpan.</p>
                </div>
            </div>
            @endif

            @if(session('status'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-6 flex items-center">
                <i class="fas fa-check-circle text-emerald-500 text-xl mr-3"></i>
                <p class="text-sm font-bold text-emerald-800">{{ session('status') }}</p>
            </div>
            @endif

            <div class="flex flex-col md:flex-row gap-8">
                
                <div class="w-full md:w-1/3 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">1. Registrasi Wajah</h3>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">Pindai wajah Anda sebagai data referensi awal (Encoding) untuk sistem Face Recognition.</p>
                    
                    <div class="relative bg-slate-50 rounded-3xl overflow-hidden aspect-[3/4] flex items-center justify-center mb-6 border-2 border-dashed border-slate-300 shadow-inner">
                        <video id="webcam" autoplay playsinline class="absolute inset-0 w-full h-full object-cover transform scale-x-[-1] hidden"></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        <div id="cam-placeholder" class="text-center text-slate-400">
                            <i class="fas fa-camera text-5xl mb-3 opacity-50"></i>
                            <p class="text-sm font-bold tracking-wide">Kamera Nonaktif</p>
                        </div>
                    </div>

                    @if(!Auth::user()->face_embedding)
                        <button id="btn-start-cam" type="button" class="w-full mb-3 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3.5 rounded-xl transition shadow-md">
                            <i class="fas fa-video mr-2"></i> Nyalakan Kamera
                        </button>
                        <button id="btn-capture" type="button" class="w-full hidden bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-blue-200">
                            <i class="fas fa-camera mr-2"></i> Ambil & Simpan Wajah
                        </button>
                        <p id="status-face" class="text-center text-sm font-bold mt-3 hidden"></p>
                    @else
                        <div class="w-full bg-emerald-50 border border-emerald-200 text-emerald-600 font-bold py-3.5 rounded-xl text-center">
                            <i class="fas fa-check-circle mr-2"></i> Wajah Terdaftar
                        </div>
                    @endif
                </div>

                <div class="w-full md:w-2/3 space-y-8">
                    
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">2. Kelengkapan Data Diri</h3>
                        
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-5">
                                <label for="nim" class="block text-sm font-bold text-gray-700 mb-2">Nomor Induk Mahasiswa (NIM)</label>
                                <input id="nim" type="text" name="nim" value="{{ old('nim', Auth::user()->nim) }}" readonly
                                    class="w-full rounded-xl border-gray-200 bg-gray-100 text-gray-500 py-3.5 px-4 cursor-not-allowed focus:ring-0">
                                <p class="text-xs font-medium text-amber-600 mt-2"><i class="fas fa-lock text-xs mr-1"></i> NIM terhubung ke Master Data dan tidak dapat diubah.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3.5 px-4 shadow-sm">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3.5 px-4 shadow-sm">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-8 rounded-xl transition shadow-md">
                                    Simpan Data Diri
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">3. Ganti Kata Sandi</h3>
                        
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-5">
                                <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                                <input id="current_password" type="password" name="current_password" required placeholder="Masukkan kata sandi lama Anda"
                                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3.5 px-4 shadow-sm">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-rose-500" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                <div>
                                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                                    <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3.5 px-4 shadow-sm">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-rose-500" />
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Ulangi Kata Sandi Baru</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ketik ulang sandi baru"
                                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3.5 px-4 shadow-sm">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-rose-500" />
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md shadow-blue-200">
                                    Perbarui Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const btnStart = document.getElementById('btn-start-cam');
        const btnCapture = document.getElementById('btn-capture');
        const placeholder = document.getElementById('cam-placeholder');
        const statusText = document.getElementById('status-face');

        if(btnStart) {
            btnStart.addEventListener('click', async () => {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;
                    video.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    btnStart.classList.add('hidden');
                    btnCapture.classList.remove('hidden');
                } catch (err) {
                    alert('Gagal mengakses kamera: Pastikan Anda memberikan izin kamera di browser.');
                }
            });
        }

        if(btnCapture) {
            btnCapture.addEventListener('click', async () => {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0);

                const imageBase64 = canvas.toDataURL('image/jpeg');
                
                btnCapture.disabled = true;
                btnCapture.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
                statusText.classList.remove('hidden');
                statusText.classList.add('text-blue-600');
                statusText.innerHTML = "Mengirim data ke AI... ⏳";

                try {
                    const response = await fetch("{{ route('profile.face') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ image: imageBase64 })
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.status === 'success') {
                        statusText.classList.remove('text-blue-600', 'text-rose-500');
                        statusText.classList.add('text-emerald-600');
                        statusText.innerHTML = "✅ Wajah berhasil disimpan!";
                        btnCapture.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Selesai';
                        
                        // Otomatis refresh halaman agar status terkunci
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        throw new Error(result.message || 'Wajah tidak terdeteksi.');
                    }
                } catch (err) {
                    statusText.classList.remove('text-blue-600', 'text-emerald-600');
                    statusText.classList.add('text-rose-500');
                    statusText.innerHTML = "❌ " + err.message;
                    btnCapture.disabled = false;
                    btnCapture.classList.replace('bg-blue-600', 'bg-slate-800');
                    btnCapture.classList.replace('hover:bg-blue-700', 'hover:bg-slate-900');
                    btnCapture.innerHTML = '<i class="fas fa-redo mr-2"></i> Coba Foto Ulang';
                }
            });
        }
    </script>
</x-app-layout>