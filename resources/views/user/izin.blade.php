<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Izin & Sakit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-blue-50 border border-blue-100 rounded-3xl p-6 sm:p-8 shadow-sm flex items-start gap-4">
                <div class="bg-blue-600 text-white p-3 rounded-2xl shrink-0 shadow-lg shadow-blue-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-extrabold text-blue-900 mb-1">Informasi Pengajuan</h4>
                    <p class="text-sm text-blue-800 leading-relaxed">Pengajuan izin atau sakit wajib menyertakan bukti berupa dokumen pendukung (Surat Dokter / Surat Keterangan). Pengajuan yang disetujui akan otomatis tercatat sebagai kehadiran "Izin/Sakit" pada sistem absensi Face Recognition.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 font-bold rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 font-medium text-sm rounded-r-lg shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Formulir Pengajuan Baru</h3>
                
                <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jenis Pengajuan</label>
                            <select name="jenis_izin" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="" disabled selected>Pilih Jenis...</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin (Keperluan Lain)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Absen</label>
                            <input type="date" name="tanggal" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Keterangan / Alasan</label>
                        <textarea name="keterangan" rows="3" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Tuliskan alasan detail ketidakhadiran Anda..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Unggah Bukti (PDF / JPG / PNG)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition group cursor-pointer" onclick="document.getElementById('file-upload').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative cursor-pointer bg-white rounded-md font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-1">
                                        Pilih File
                                    </span>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-2" id="file-name">Maksimal ukuran file: 2MB</p>
                            </div>
                            <input id="file-upload" name="bukti_file" type="file" class="sr-only" onchange="document.getElementById('file-name').innerText = this.files[0].name" required>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>