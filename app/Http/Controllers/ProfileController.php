<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // ========================================================
    // UPDATE PROFIL (Hanya Nama, Email, dan NIM)
    // ========================================================
    public function update(Request $request)
    {
        $user = $request->user();

        // Validasi data (Alamat, Tempat/Tanggal Lahir dihilangkan)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'nim' => ['required', 'string', 'max:20', 'unique:users,nim,'.$user->id],
        ]);

        // Isi data user dengan data baru
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }

    // ========================================================
    // FUNGSI BARU: GANTI PASSWORD
    // ========================================================
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('status', 'Password Anda berhasil diperbarui!');
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
    // FUNGSI: Menerima Wajah dan Mengirim ke Database
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