<!DOCTYPE html>
<html>
<head>
    <title>Rekap Absensi Mahasiswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KEHADIRAN MAHASISWA</h2>
        <p>Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Mata Kuliah</th>
                <th>Waktu Absen</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensis as $index => $absen)
            @php
                $waktu = \Carbon\Carbon::parse($absen->waktu_absen);
                $hari = $waktu->translatedFormat('l');
                $jam = $waktu->format('H:i');
                
                $mk = 'Mata Kuliah Pengganti';
                if ($hari == 'Senin') { $mk = 'Kriptografi'; }
                elseif ($hari == 'Selasa') { $mk = ($jam < '19:00') ? 'Virtual dan Augmented' : 'Proyek Teknologi Informasi'; }
                elseif ($hari == 'Rabu') { $mk = ($jam < '19:00') ? 'Pengolah Citra' : 'Cloud Computering'; }
                elseif ($hari == 'Kamis') { $mk = ($jam < '19:00') ? 'Arsitektur Enterprise' : 'Internet Of Things'; }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $absen->user->name ?? '-' }}</td>
                <td>{{ $absen->user->nim ?? '-' }}</td>
                <td>{{ $mk }}</td>
                <td>{{ $hari }}, {{ $waktu->format('d/m/Y H:i') }}</td>
                <td>{{ $absen->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>