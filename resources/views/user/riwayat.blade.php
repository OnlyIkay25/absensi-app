<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Kehadiran & Perizinan') }}
        </h2>
    </x-slot>

    @php
        function getInfoKuliah($waktu_absen) {
            $hari = \Carbon\Carbon::parse($waktu_absen)->translatedFormat('l');
            $jam = \Carbon\Carbon::parse($waktu_absen)->format('H:i');
            
            if ($hari == 'Senin') {
                return ['mk' => 'Kriptografi', 'dosen' => 'Erick Harlest Budi Harjo'];
            } elseif ($hari == 'Selasa') {
                return ($jam < '19:00') 
                    ? ['mk' => 'Virtual dan Augmented', 'dosen' => 'Muhammad Muharrom']
                    : ['mk' => 'Proyek Teknologi Informasi', 'dosen' => 'Dr. Heri Kuswara'];
            } elseif ($hari == 'Rabu') {
                return ($jam < '19:00') 
                    ? ['mk' => 'Pengolah Citra', 'dosen' => 'Giatika Chrisnawati']
                    : ['mk' => 'Cloud Computering', 'dosen' => 'Hidayat Muhammad Nur'];
            } elseif ($hari == 'Kamis') {
                return ($jam < '19:00') 
                    ? ['mk' => 'Arsitektur Enterprise', 'dosen' => 'Rinawati']
                    : ['mk' => 'Internet Of Things', 'dosen' => 'Sigit Wibawa'];
            }
            return ['mk' => 'Mata Kuliah Pengganti', 'dosen' => 'Dosen Pengampu'];
        }
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 border border-gray-100">
                <h3 class="text-xl font-bold mb-6 text-gray-900 border-b pb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Catatan Absensi Real-Time
                </h3>

                @if($absensis->isEmpty())
                    <div class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-500 font-medium">Belum ada riwayat absensi perkuliahan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-100 rounded-lg overflow-hidden">
                            <thead class="bg-indigo-50/50">
                                <tr>
                                    <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase">Waktu & Hari</th>
                                    <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase">Mata Kuliah & Dosen</th>
                                    <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase">Status</th>
                                    <th class="py-4 px-6 text-left text-xs font-extrabold text-indigo-900 uppercase">Bukti Foto AI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($absensis as $index => $absen)
                                    @php $infoKuliah = getInfoKuliah($absen->waktu_absen); @endphp
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="py-4 px-6 text-sm">
                                            <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($absen->waktu_absen)->translatedFormat('l') }}</div>
                                            <div class="text-gray-500">{{ \Carbon\Carbon::parse($absen->waktu_absen)->format('d M Y - H:i') }}</div>
                                        </td>
                                        
                                        <td class="py-4 px-6 text-sm">
                                            <div class="font-bold text-blue-700">{{ $infoKuliah['mk'] }}</div>
                                            <div class="text-gray-500 text-xs mt-0.5">Dosen: {{ $infoKuliah['dosen'] }}</div>
                                        </td>

                                        <td class="py-4 px-6 text-sm">
                                            @if($absen->status == 'Hadir')
                                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-md bg-emerald-100 text-emerald-700">Hadir</span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-md bg-amber-100 text-amber-700">{{ $absen->status }}</span>
                                            @endif
                                        </td>

                                        <td class="py-4 px-6 text-sm">
                                            @if($absen->foto_snapshot)
                                                <img src="{{ $absen->foto_snapshot }}" alt="Bukti" class="h-14 w-20 object-cover rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:scale-150 transition transform origin-left">
                                            @else
                                                <span class="text-gray-400 italic text-xs">Tanpa foto</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 border border-gray-100 mt-8">
                <h3 class="text-xl font-bold mb-6 text-gray-900 border-b pb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Status Pengajuan Izin & Sakit
                </h3>
                
                @if($izins->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-500 text-sm font-medium">Belum ada riwayat pengajuan izin atau sakit.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                    <th class="py-4 px-6 font-bold">Tanggal Pengajuan</th>
                                    <th class="py-4 px-6 font-bold">Jenis</th>
                                    <th class="py-4 px-6 font-bold">Keterangan</th>
                                    <th class="py-4 px-6 font-bold text-center">Status Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($izins as $izin)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="py-4 px-6 text-sm text-gray-900 font-medium">{{ $izin->created_at->format('d M Y - H:i') }}</td>
                                        <td class="py-4 px-6 text-sm font-bold {{ $izin->jenis_izin == 'Sakit' ? 'text-rose-600' : 'text-amber-600' }}">{{ $izin->jenis_izin }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-600 max-w-xs truncate">{{ $izin->keterangan }}</td>
                                        <td class="py-4 px-6 text-sm text-center">
                                            @if($izin->status == 'Menunggu')
                                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-bold">Menunggu</span>
                                            @elseif($izin->status == 'Disetujui')
                                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold">✅ Disetujui</span>
                                            @else
                                                <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-xs font-bold">❌ Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>