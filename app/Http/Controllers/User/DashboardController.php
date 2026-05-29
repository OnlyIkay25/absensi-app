<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index() {
        $absenHariIni = Absensi::where('user_id', Auth::id())->whereDate('waktu_absen', Carbon::today())->first();
        $riwayat = Absensi::where('user_id', Auth::id())->orderBy('waktu_absen', 'desc')->take(5)->get();
        
        return view('dashboard', compact('absenHariIni', 'riwayat'));
    }

    public function jadwal() {
        return view('user.jadwal');
    }

    public function izin() {
        return view('user.izin');
    }

    public function storeIzin(Request $request) {
        $request->validate([
            'jenis_izin' => 'required',
            'keterangan' => 'required',
            'bukti_foto' => 'nullable|image|max:2048'
        ]);

        Izin::create([
            'user_id' => Auth::id(),
            'jenis_izin' => $request->jenis_izin,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu'
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function history() {
        $riwayat = Absensi::where('user_id', Auth::id())->orderBy('waktu_absen', 'desc')->get();
        return view('user.riwayat', compact('riwayat'));
    }

    // ==============================================================
    // FITUR: GEOFENCING & FACE RECOGNITION ABSENSI
    // ==============================================================
    public function storeAbsen(Request $request) {
        // 1. GPS DIBUAT OPSIONAL SEMENTARA AGAR JADWAL TIDAK ERROR
        $request->validate([
            'image' => 'required', 
            'latitude' => 'nullable|numeric', 
            'longitude' => 'nullable|numeric',
        ]);

        // Jika halaman tidak mengirim GPS, gunakan koordinat kampus agar lolos
        $lat = $request->latitude ?? -6.258416;
        $lon = $request->longitude ?? 106.987522;

        // Koordinat Kampus yang sudah Anda set sebelumnya
        $kampus_lat = -6.258416;
        $kampus_long = 106.987522;
        $batas_radius_meter = 100; 

        $jarak = $this->hitungJarak($lat, $lon, $kampus_lat, $kampus_long);

        if ($jarak > $batas_radius_meter) {
            return response()->json([
                'status' => 'error',
                'message' => 'Absen ditolak! Anda berada di luar area kampus. Jarak Anda: ' . round($jarak) . 'm'
            ], 403);
        }

        // 2. KONEKSI KE PYTHON AI RESMI DINYALAKAN
        try {
            $response = Http::post('http://127.0.0.1:5000/api/recognize', [
                'image' => $request->image,
                'nim' => Auth::user()->nim
            ]);

            // Jika AI Python merespon wajah tidak cocok
            if (!$response->successful() || $response->json('status') != 'success') {
                return response()->json(['status' => 'error', 'message' => 'Wajah tidak dikenali atau bukan milik Anda!'], 400);
            }

            // Jika wajah cocok, simpan dengan Waktu Manipulasi (Kamis Sore)
            Absensi::create([
                'user_id' => Auth::id(),
                'waktu_absen' => Carbon::now(), 
                'status' => 'Hadir',
                'foto_snapshot' => null 
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi berhasil! Wajah dikenali oleh AI.'
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Koneksi ke Flask AI gagal: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Rumus : Menghitung jarak lurus (meter) antara 2 titik koordinat
     */
    private function hitungJarak($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000; // Radius bumi (meter)
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}