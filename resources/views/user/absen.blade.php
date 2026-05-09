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

        // Nyalakan kamera otomatis saat halaman dibuka
        navigator.mediaDevices.getUserMedia({ video: true }).then(s => video.srcObject = s);

        document.getElementById('btn-absen').addEventListener('click', async () => {
            const canvas = document.getElementById('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            const image = canvas.toDataURL('image/jpeg');

            statusText.innerText = "Memverifikasi Wajah... 🔍";
            
            const res = await fetch("{{ route('absen.store') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ image })
            });

            const data = await res.json();
            if(data.status === 'success') {
                statusText.innerHTML = "<span class='text-emerald-600'>✅ " + data.message + "</span>";
                setTimeout(() => window.location.href = "/dashboard", 2000);
            } else {
                statusText.innerHTML = "<span class='text-rose-600'>❌ " + data.message + "</span>";
            }
        });
    </script>
</x-app-layout>