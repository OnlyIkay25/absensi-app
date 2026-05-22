<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Izin;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function jadwal()
    {
        return view('user.jadwal');
    }

    public function storeAbsen(Request $request)
    {
        $user = Auth::user();

        if (!$user->face_embedding) {
            return response()->json(['status' => 'error', 'message' => 'Anda belum merekam wajah!'], 400);
        }

        try {
            $response = Http::post('http://127.0.0.1:5000/api/verify', [
                'image' => $request->image,
                'stored_embedding' => json_decode($user->face_embedding)
            ]);

            $result = $response->json();

            if ($response->successful() && $result['status'] == 'success') {
                // LOGIKA BARU: Menyimpan Mata Kuliah dan Status Terlambat/Hadir
                Absensi::create([
                    'user_id' => $user->id,
                    'waktu_absen' => now(),
                    'status' => $request->status_presensi ?? 'Hadir', // Otomatis mencatat Hadir/Terlambat
                    'mata_kuliah' => $request->mata_kuliah,           // Otomatis mencatat Nama Mata Kuliah
                    'foto_snapshot' => $request->image
                ]);
                return response()->json(['status' => 'success', 'message' => 'Absen Berhasil!']);
            }
            return response()->json(['status' => 'error', 'message' => $result['message']], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Mesin AI Mati atau tidak merespon.'], 500);
        }
    }

    // =======================================================
    // FUNGSI IZIN & RIWAYAT (Tetap Aman & Tidak Diubah)
    // =======================================================

    public function izin()
    {
        // Ambil riwayat izin khusus untuk mahasiswa yang sedang login
        $izins = \App\Models\Izin::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view('user.izin', compact('izins')); 
    }

    public function storeIzin(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required',
            'keterangan' => 'required',
            'bukti_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan file ke folder public/uploads/izin
            $file->move(public_path('uploads/izin'), $filename);
            $path = 'uploads/izin/' . $filename;
        }

        Izin::create([
            'user_id' => Auth::id(),
            'jenis_izin' => $request->jenis_izin,
            'keterangan' => $request->keterangan,
            'bukti_file' => $path,
            'status' => 'Menunggu'
        ]);

        return redirect()->back()->with('success', '✅ Pengajuan berhasil dikirim! Menunggu persetujuan Admin.');
    }

    public function history()
    {
        // Mengambil data riwayat absen wajah
        $absensis = \App\Models\Absensi::where('user_id', Auth::id())->orderBy('waktu_absen', 'desc')->get();
        
        // Mengambil data riwayat pengajuan izin/sakit
        $izins = \App\Models\Izin::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        
        // Kirim keduanya ke halaman riwayat
        return view('user.riwayat', compact('absensis', 'izins'));
    }
}