@extends('layouts.admin')
@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Dashboard Analytic</h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan statistik presensi mahasiswa secara real-time.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 hover:shadow-md transition">
            <div class="bg-blue-50 p-4 rounded-2xl text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Mahasiswa</p>
                <p class="text-3xl font-black text-gray-900">{{ $totalMahasiswa }} <span class="text-sm font-medium text-gray-400">Orang</span></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 hover:shadow-md transition">
            <div class="bg-emerald-50 p-4 rounded-2xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Hadir Hari Ini</p>
                <p class="text-3xl font-black text-gray-900">{{ $hadirHariIni }} <span class="text-sm font-medium text-gray-400">Orang</span></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 hover:shadow-md transition">
            <div class="bg-amber-50 p-4 rounded-2xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Izin / Sakit</p>
                <p class="text-3xl font-black text-gray-900">{{ $izinHariIni }} <span class="text-sm font-medium text-gray-400">Pengajuan</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-800">Grafik Kehadiran (7 Hari Terakhir)</h3>
        </div>
        <div class="relative w-full" style="height: 350px;">
            <canvas id="absenChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('absenChart').getContext('2d');
        
        // Mengambil data dari variabel PHP Laravel yang dikirim tadi
        const labels = {!! json_encode($labelHari) !!};
        const dataHadir = {!! json_encode($dataHadir) !!};

        new Chart(ctx, {
            type: 'bar', // Gunakan 'line' jika Anda lebih suka grafik garis melengkung
            data: {
                labels: labels,
                datasets: [{
                    label: 'Mahasiswa Hadir',
                    data: dataHadir,
                    backgroundColor: 'rgba(16, 185, 129, 0.85)', // Warna Emerald modern
                    hoverBackgroundColor: 'rgba(16, 185, 129, 1)', 
                    borderRadius: 8, // Ujung batang membulat ala aplikasi iOS
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#9ca3af' },
                        grid: { borderDash: [4, 4], color: '#f3f4f6' }
                    },
                    x: {
                        ticks: { color: '#6b7280', font: { weight: 'bold' } },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        padding: 12,
                        titleFont: { size: 14 },
                        bodyFont: { size: 14 }
                    }
                }
            }
        });
    });
</script>
@endsection