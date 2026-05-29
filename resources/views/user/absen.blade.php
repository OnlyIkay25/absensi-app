<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Pindai Wajah Absensi 📸</h1>
            
            <div class="bg-white p-8 rounded-3xl shadow-2xl border-t-8 border-emerald-500">
                <div class="relative w-full max-w-md mx-auto rounded-2xl overflow-hidden bg-black aspect-video flex items-center justify-center">
                    <video id="webcam" autoplay playsinline class="w-full h-full object-cover"></video>
                    <canvas id="canvas" class="hidden"></canvas>
                </div>

                <div class="mt-8">
                    <button id="btn-absen" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xl px-12 py-4 rounded-2xl font-bold shadow-lg transition-all transform hover:scale-105">
                        KIRIM KEHADIRAN
                    </button>
                </div>
                
                <p id="status" class="mt-6 text-lg font-bold text-gray-600"></p>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const statusText = document.getElementById('status');
        const btnAbsen = document.getElementById('btn-absen');

        // Nyalakan kamera otomatis saat halaman dibuka
        navigator.mediaDevices.getUserMedia({ video: true }).then(s => video.srcObject = s);

        btnAbsen.addEventListener('click', () => {
            // 1. Cek Dukungan GPS Browser
            if (!navigator.geolocation) {
                statusText.innerHTML = "<span class='text-rose-600'>❌ Browser Anda tidak mendukung fitur Lokasi/GPS.</span>";
                return;
            }

            // Ubah status dan matikan tombol sementara agar tidak diklik 2 kali
            statusText.innerHTML = "Mencari koordinat lokasi Anda... 📍";
            btnAbsen.disabled = true;
            btnAbsen.classList.add('opacity-50', 'cursor-not-allowed');
            btnAbsen.classList.remove('hover:scale-105');

            // 2. Minta Izin Lokasi & Dapatkan Titik Kordinat
            navigator.geolocation.getCurrentPosition(
                async function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // 3. Tangkap Gambar Wajah dari Video
                    const canvas = document.getElementById('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);
                    const image = canvas.toDataURL('image/jpeg');

                    statusText.innerHTML = "Memverifikasi Wajah & Jarak Kampus... ⏳";

                    // 4. Kirim Foto + Data GPS ke Laravel
                    try {
                        const res = await fetch("{{ route('absen.store') }}", {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                            },
                            body: JSON.stringify({ 
                                image: image,
                                latitude: latitude,
                                longitude: longitude
                            })
                        });

                        const data = await res.json();
                        
                        if(data.status === 'success') {
                            statusText.innerHTML = "<span class='text-emerald-600'>✅ " + data.message + "</span>";
                            setTimeout(() => window.location.href = "/dashboard", 2000);
                        } else {
                            statusText.innerHTML = "<span class='text-rose-600'>❌ " + data.message + "</span>";
                            // Nyalakan tombol lagi jika gagal
                            btnAbsen.disabled = false;
                            btnAbsen.classList.remove('opacity-50', 'cursor-not-allowed');
                            btnAbsen.classList.add('hover:scale-105');
                        }
                    } catch (err) {
                        statusText.innerHTML = "<span class='text-rose-600'>❌ Terjadi kesalahan saat menghubungi server.</span>";
                        btnAbsen.disabled = false;
                        btnAbsen.classList.remove('opacity-50', 'cursor-not-allowed');
                        btnAbsen.classList.add('hover:scale-105');
                    }
                },
                function(error) { 
                    // 5. Tangkap Error GPS (Misal: Mahasiswa menolak klik "Allow Location")
                    let errorMsg = "Gagal mendapatkan lokasi.";
                    if (error.code === 1) errorMsg = "Absen Ditolak: Anda harus mengizinkan akses Lokasi (GPS)!";
                    if (error.code === 2) errorMsg = "Absen Ditolak: Sinyal GPS tidak tersedia.";
                    if (error.code === 3) errorMsg = "Waktu permintaan lokasi habis (Timeout). Coba klik lagi.";

                    statusText.innerHTML = "<span class='text-rose-600'>❌ " + errorMsg + "</span>";
                    btnAbsen.disabled = false;
                    btnAbsen.classList.remove('opacity-50', 'cursor-not-allowed');
                    btnAbsen.classList.add('hover:scale-105');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 } // Konfigurasi GPS Akurasi Tinggi
            );
        });
    </script>
</x-app-layout>