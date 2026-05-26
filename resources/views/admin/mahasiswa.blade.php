@extends('layouts.admin')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Panel Master Data Mahasiswa</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data NIM dan nama resmi mahasiswa sebelum registrasi mandiri dilakukan.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-500 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:shadow-sm transition flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Analitik
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-6 flex items-center gap-3">
        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
            <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Mahasiswa Baru
            </h3>
            <p class="text-xs text-gray-400 font-medium mb-6">Input NIM dan Nama Lengkap mahasiswa secara bersamaan ke pangkalan data master.</p>
            
            <form method="POST" action="{{ route('admin.store_nim') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="nim" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Induk Mahasiswa (NIM)</label>
                    <input id="nim" type="text" name="nim" required placeholder="Contoh: 17230937" 
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    @error('nim') <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="nama_lengkap" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap Mahasiswa</label>
                    <input id="nama_lengkap" type="text" name="nama_lengkap" required placeholder="Contoh: Ikrar Wira Buwana" 
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    @error('nama_lengkap') <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transition active:scale-95 text-sm">
                    Simpan ke Master Data
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Daftar Otoritas NIM Kampus
                </h3>
                <span class="text-xs font-extrabold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Total: {{ count($master_mahasiswas) }} Data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">No</th>
                            <th class="py-4 px-6">NIM</th>
                            <th class="py-4 px-6">Nama Resmi</th>
                            <th class="py-4 px-6 text-center">Status Akun</th>
                            <th class="py-4 px-6 text-center">Aksi Operasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm font-medium text-gray-700">
                        @forelse($master_mahasiswas as $index => $m)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-4 px-6 text-gray-400 font-bold">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 text-gray-900 font-bold">{{ $m->nim }}</td>
                            <td class="py-4 px-6 font-semibold">{{ $m->nama_lengkap ?? 'Belum Diisi' }}</td>
                            <td class="py-4 px-6 text-center">
                                @if($m->is_registered)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-500 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Belum Daftar
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center items-center gap-2">
                                    <button onclick="openEditModal('{{ $m->id }}', '{{ $m->nim }}', '{{ $m->nama_lengkap }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    
                                    @if(!$m->is_registered)
                                        <button onclick="openEmailModal('{{ $m->id }}', '{{ $m->nim }}')" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Kirim Email Aktivasi">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </button>
                                    @endif

                                    <form method="POST" action="{{ route('admin.delete_master', $m->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data master mahasiswa ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400 font-medium">Belum ada data master mahasiswa di dalam sistem.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="edit-modal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all p-6 sm:p-8">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Perbarui Master Data
            </h4>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition text-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="edit-form" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="edit-nim" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Induk Mahasiswa (NIM)</label>
                <input id="edit-nim" type="text" name="nim" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
            </div>
            <div>
                <label for="edit-nama" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap Sesuai Berkas</label>
                <input id="edit-nama" type="text" name="nama_lengkap" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeEditModal()" class="px-5 py-3 border border-gray-200 text-gray-500 rounded-xl font-bold text-sm hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div id="email-modal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all p-6 sm:p-8">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Kirim Surat Aktivasi
            </h4>
            <button onclick="closeEmailModal()" class="text-gray-400 hover:text-gray-600 transition text-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="email-form" method="POST" class="space-y-4">
            @csrf
            <div class="bg-amber-50 border border-amber-100 p-4 rounded-xl mb-2 text-xs text-amber-800 font-medium leading-relaxed">
                Sistem akan mengirimkan pesan berisi nomor NIM resmi ke alamat email mahasiswa di bawah ini untuk instruksi pembuatan akun secara mandiri.
            </div>
            <div>
                <label for="mhs-email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Email Mahasiswa</label>
                <input id="mhs-email" type="email" name="email" required placeholder="nama@email.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeEmailModal()" class="px-5 py-3 border border-gray-200 text-gray-500 rounded-xl font-bold text-sm hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-sm shadow-md transition">Kirim Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nim, nama) {
        const form = document.getElementById('edit-form');
        form.action = "{{ url('/admin/master-mahasiswa') }}/" + id;
        document.getElementById('edit-nim').value = nim;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-modal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }

    function openEmailModal(id, nim) {
        const form = document.getElementById('email-form');
        form.action = "{{ url('/admin/master-mahasiswa') }}/" + id + "/kirim-email";
        document.getElementById('email-modal').classList.remove('hidden');
    }
    function closeEmailModal() {
        document.getElementById('email-modal').classList.add('hidden');
    }
</script>
@endsection