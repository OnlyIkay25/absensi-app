@extends('layouts.admin')
@section('content')
    <div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Log Absensi Harian</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau kehadiran mahasiswa secara real-time dari kamera AI.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Nama Mahasiswa</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Waktu Absen</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Bukti Foto AI</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($absensis as $index => $absen)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="py-4 px-6 text-sm text-slate-600 font-semibold">{{ $index + 1 }}</td>
                            
                            <td class="py-4 px-6 text-sm">
                                <div class="font-bold text-slate-900">
                                    {{ $absen->user->name ?? 'Mahasiswa Tidak Dikenal' }}
                                </div>
                            </td>

                            <td class="py-4 px-6 text-sm text-slate-600 font-medium">
                                {{ \Carbon\Carbon::parse($absen->waktu_absen)->translatedFormat('l, d M Y - H:i:s') }}
                            </td>
                            
                            <td class="py-4 px-6 text-sm">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    {{ $absen->status }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-6 text-sm">
                                @if($absen->foto_snapshot)
                                    <img src="{{ $absen->foto_snapshot }}" alt="Bukti" class="h-12 w-20 object-cover rounded shadow-sm hover:scale-150 transition transform origin-left cursor-pointer border border-slate-200">
                                @else
                                    <span class="text-gray-400 italic">No Photo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="font-medium text-slate-500">Belum ada mahasiswa yang absen hari ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection