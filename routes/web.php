<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\ExportController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

// ==========================================
// RUTE USER / MAHASISWA
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal-kuliah', [DashboardController::class, 'jadwal'])->name('jadwal.index');
    Route::post('/absen/store', [DashboardController::class, 'storeAbsen'])->name('absen.store');

    Route::get('/pengajuan-izin', [DashboardController::class, 'izin'])->name('izin.form');
    Route::post('/pengajuan-izin', [DashboardController::class, 'storeIzin'])->name('izin.store');
    Route::get('/riwayat', [DashboardController::class, 'history'])->name('history.index');
});

// ==========================================
// RUTE PROFILE & REGISTRASI WAJAH
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/face', [ProfileController::class, 'registerFace'])->name('profile.face');
});

// ==========================================
// RUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    Route::get('/export-excel', [ExportController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/export-pdf', [ExportController::class, 'exportPdf'])->name('admin.export.pdf');

    Route::get('/dashboard', function () { 
        $hariIni = \Carbon\Carbon::today();
        $totalMahasiswa = \App\Models\User::where('role', 'user')->count();
        $hadirHariIni = \App\Models\Absensi::whereDate('waktu_absen', $hariIni)->count();
        $izinHariIni = \App\Models\Izin::whereDate('created_at', $hariIni)->count();

        $labelHari = [];
        $dataHadir = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = \Carbon\Carbon::today()->subDays($i);
            $labelHari[] = $tanggal->translatedFormat('l'); 
            $dataHadir[] = \App\Models\Absensi::whereDate('waktu_absen', $tanggal)->count();
        }

        return view('admin.dashboard', compact('totalMahasiswa', 'hadirHariIni', 'izinHariIni', 'labelHari', 'dataHadir')); 
    })->name('admin.dashboard');
    
    Route::get('/mahasiswa', function () { 
        $mahasiswas = User::where('role', 'user')->get();
        $master_mahasiswas = \App\Models\MasterMahasiswa::orderBy('created_at', 'desc')->get();
        return view('admin.mahasiswa', compact('mahasiswas', 'master_mahasiswas')); 
    })->name('admin.mahasiswa');

    Route::post('/master-mahasiswa', function (Illuminate\Http\Request $request) {
        $request->validate([
            'nim' => 'required|unique:master_mahasiswas,nim',
            'nama_lengkap' => 'required|string|max:255'
        ]);
        
        \App\Models\MasterMahasiswa::create([
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'is_registered' => false
        ]);

        return redirect()->back()->with('success', 'Mahasiswa baru berhasil ditambahkan ke Master Data!');
    })->name('admin.store_nim');

    // ==============================================================
    // LOGIKA UPDATE BARU: Sinkronisasi ke Tabel Users
    // ==============================================================
    Route::patch('/master-mahasiswa/{id}', function (Illuminate\Http\Request $request, $id) {
        $mahasiswa = \App\Models\MasterMahasiswa::findOrFail($id);
        $nimLama = $mahasiswa->nim; // Simpan NIM lama untuk mencari akun user

        $request->validate([
            'nim' => 'required|unique:master_mahasiswas,nim,' . $id,
            'nama_lengkap' => 'required|string|max:255'
        ]);

        // 1. Update data di tabel master
        $mahasiswa->update([
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap
        ]);

        // 2. Jika akun user sudah pernah dibuat, ikutan di-update!
        $user = \App\Models\User::where('nim', $nimLama)->first();
        if ($user) {
            $user->update([
                'nim' => $request->nim,
                'name' => $request->nama_lengkap
            ]);
        }

        return redirect()->back()->with('success', 'Data Master & Akun Mahasiswa berhasil diperbarui!');
    })->name('admin.update_master');

    // ==============================================================
    // LOGIKA DELETE BARU: Menghapus Total Sampai ke Akunnya
    // ==============================================================
    Route::delete('/master-mahasiswa/{id}', function ($id) {
        $mahasiswa = \App\Models\MasterMahasiswa::findOrFail($id);
        $nim = $mahasiswa->nim;

        // 1. Hapus dari tabel master
        $mahasiswa->delete();

        // 2. Cari akun user yang menggunakan NIM ini, lalu hapus juga!
        $user = \App\Models\User::where('nim', $nim)->first();
        if ($user) {
            // (Opsional) Hapus juga riwayat absen dan izinnya jika ingin bersih total
            \App\Models\Absensi::where('user_id', $user->id)->delete();
            \App\Models\Izin::where('user_id', $user->id)->delete();
            
            // Hapus akunnya
            $user->delete();
        }

        return redirect()->back()->with('success', 'Data Master & Akun Mahasiswa berhasil dihapus bersih dari sistem!');
    })->name('admin.delete_master');

    Route::post('/master-mahasiswa/{id}/kirim-email', function (Illuminate\Http\Request $request, $id) {
        $request->validate(['email' => 'required|email']);
        $mahasiswa = \App\Models\MasterMahasiswa::findOrFail($id);
        $emailTujuan = $request->email;

        $pesan = "Halo " . $mahasiswa->nama_lengkap . ",\n\nNIM Anda telah aktif di sistem HadirMas. Silakan lakukan registrasi akun menggunakan nomor NIM Anda.\n\nNIM Anda: " . $mahasiswa->nim . "\n\nTerima kasih.";
        
        \Illuminate\Support\Facades\Mail::raw($pesan, function ($message) use ($emailTujuan) {
            $message->to($emailTujuan)->subject('Aktivasi Akun Mahasiswa Baru - HadirMas');
        });

        return redirect()->back()->with('success', 'Email instruksi registrasi berhasil dikirim!');
    })->name('admin.kirim_email');

    Route::get('/absensi', function () { 
        $absensis = \App\Models\Absensi::with('user')->orderBy('waktu_absen', 'desc')->get();
        return view('admin.absensi', compact('absensis')); 
    })->name('admin.absensi');

    Route::get('/izin', function () { 
        $izins = \App\Models\Izin::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.izin', compact('izins')); 
    })->name('admin.izin');

    Route::post('/izin/{id}/approve', function ($id) {
        $izin = \App\Models\Izin::findOrFail($id);
        $izin->update(['status' => 'Disetujui']);
        
        \App\Models\Absensi::create([
            'user_id' => $izin->user_id,
            'waktu_absen' => now(),
            'status' => $izin->jenis_izin, 
            'foto_snapshot' => null
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil disetujui.');
    })->name('admin.izin.approve');

    Route::post('/izin/{id}/reject', function ($id) {
        $izin = \App\Models\Izin::findOrFail($id);
        $izin->update(['status' => 'Ditolak']);
        return redirect()->back()->with('error', 'Pengajuan izin telah ditolak.');
    })->name('admin.izin.reject');
});

require __DIR__.'/auth.php';