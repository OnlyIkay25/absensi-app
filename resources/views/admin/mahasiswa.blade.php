@extends('layouts.admin')
@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Mahasiswa</h1>
            <p class="text-sm text-gray-500 mt-1">Total <span class="font-bold text-gray-900">{{ $mahasiswas->count() }}</span> mahasiswa terdaftar.</p>
        </div>
        
        <div class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="searchInput" onkeyup="searchTable()" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" placeholder="Cari Nama atau NIM Mahasiswa...">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100" id="mahasiswaTable">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Informasi Mahasiswa</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">NIM</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status Wajah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($mahasiswas as $mhs)
                        <tr class="hover:bg-slate-50 transition duration-150 baris-mahasiswa">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                        {{ strtoupper(substr($mhs->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900 nama-mhs">{{ $mhs->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $mhs->email }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="py-4 px-6 text-sm font-semibold text-gray-700 nim-mhs">
                                {{ $mhs->nim ?? '-' }}
                            </td>
                            
                            <td class="py-4 px-6 text-sm">
                                @if(isset($mhs->stored_embedding) || isset($mhs->face_embedding))
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        <span class="mr-1.5 h-2 w-2 rounded-full bg-emerald-500 inline-block align-middle mt-1"></span> Wajah Tersimpan
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                                        <span class="mr-1.5 h-2 w-2 rounded-full bg-rose-500 inline-block align-middle mt-1"></span> Belum Rekam
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <span class="font-medium text-slate-500">Belum ada data mahasiswa.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div id="noDataMessage" class="hidden py-12 text-center text-slate-500 font-medium">
            <svg class="w-12 h-12 mb-3 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Mahasiswa yang dicari tidak ditemukan.
        </div>
    </div>
</div>

<script>
    function searchTable() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let rows = document.querySelectorAll(".baris-mahasiswa");
        let dataFound = false;

        rows.forEach(row => {
            let name = row.querySelector(".nama-mhs").innerText.toLowerCase();
            let nim = row.querySelector(".nim-mhs").innerText.toLowerCase();

            // Jika kata kunci cocok dengan Nama atau NIM
            if (name.includes(input) || nim.includes(input)) {
                row.style.display = ""; // Tampilkan baris
                dataFound = true;
            } else {
                row.style.display = "none"; // Sembunyikan baris
            }
        });

        // Logika pesan "Tidak ditemukan"
        let noDataMessage = document.getElementById("noDataMessage");
        if(dataFound || input === '') {
            noDataMessage.classList.add("hidden");
        } else {
            noDataMessage.classList.remove("hidden");
        }
    }
</script>
@endsection