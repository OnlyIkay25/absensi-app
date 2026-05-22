<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http; // Ini wajib dipanggil untuk ngobrol sama API Python

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Validasi data yang masuk
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'nim' => ['nullable', 'string', 'max:20', 'unique:users,nim,'.$user->id],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
        ]);

        // Isi data user dengan data baru dari form
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Simpan ke database
        $user->save();

        // Kembalikan ke halaman profil dengan pesan sukses
        return redirect()->route('profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // ========================================================
    // FUNGSI BARU: Menerima Wajah dan Mengirim ke Database
    // ========================================================
    public function registerFace(Request $request)
    {
        $request->validate([
            'image' => 'required|string'
        ]);

        try {
            // Tembak data ke API Python Flask yang standby di Port 5000
            $response = Http::post('http://127.0.0.1:5000/api/encode', [
                'image' => $request->image
            ]);

            $result = $response->json();

            // Jika Python membalas sukses
            if ($response->successful() && $result['status'] == 'success') {
                $user = $request->user();
                // Simpan deret angka wajah ke database MySQL
                $user->face_embedding = json_encode($result['embedding']);
                $user->save();

                return response()->json(['status' => 'success', 'message' => 'Wajah berhasil dipindai & disimpan!']);
            }

            // Jika Python menolak (misal wajah tidak kelihatan/ada dua orang)
            return response()->json(['status' => 'error', 'message' => $result['message'] ?? 'Gagal memproses wajah'], 400);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal terhubung ke Mesin AI. Pastikan terminal Python menyala!'], 500);
        }
    }
}