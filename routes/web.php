<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
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
// RUTE KHUSUS ADMIN (Sudah Dilengkapi!)
// ==========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () { 
        return view('admin.dashboard'); 
    })->name('admin.dashboard');
    
    // Rute Data Mahasiswa yang tadi dicari oleh Laravel
    Route::get('/mahasiswa', function () { 
        $mahasiswas = User::where('role', 'user')->get();
        return view('admin.mahasiswa', compact('mahasiswas')); 
    })->name('admin.mahasiswa');


   // Rute untuk melihat data absensi
    Route::get('/absensi', function () { 
        // Ambil semua data absensi beserta nama usernya, urutkan dari yang terbaru
        $absensis = \App\Models\Absensi::with('user')->orderBy('waktu_absen', 'desc')->get();
        return view('admin.absensi', compact('absensis')); 
    })->name('admin.absensi');

   // Rute untuk melihat data izin
    Route::get('/izin', function () { 
        $izins = \App\Models\Izin::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.izin', compact('izins')); 
    })->name('admin.izin');

    // Rute Admin Menerima Izin
    Route::post('/izin/{id}/approve', function ($id) {
        $izin = \App\Models\Izin::findOrFail($id);
        $izin->update(['status' => 'Disetujui']);
        
        // Otomatis catat ke log absen mahasiswa
        \App\Models\Absensi::create([
            'user_id' => $izin->user_id,
            'waktu_absen' => now(),
            'status' => $izin->jenis_izin, // Mengisi 'Sakit' atau 'Izin'
            'foto_snapshot' => null
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil disetujui dan masuk ke riwayat absensi.');
    })->name('admin.izin.approve');

    // Rute Admin Menolak Izin
    Route::post('/izin/{id}/reject', function ($id) {
        $izin = \App\Models\Izin::findOrFail($id);
        $izin->update(['status' => 'Ditolak']);
        return redirect()->back()->with('error', 'Pengajuan izin telah ditolak.');
    })->name('admin.izin.reject');
});

require __DIR__.'/auth.php';