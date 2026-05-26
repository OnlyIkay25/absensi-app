<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MasterMahasiswa;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDASI KETAT SUPER AMAN
        $request->validate([
            'nim' => ['required', 'string', 'max:20', 'exists:master_mahasiswas,nim', 'unique:users,nim'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required', 
                'confirmed', 
                'max:12', // Maksimal 12 Karakter
                Rules\Password::min(8) // Minimal 8 Karakter
                    ->mixedCase()      // Wajib ada Huruf Besar & Huruf Kecil
                    ->symbols()        // Wajib ada Karakter Khusus (!@#$%^&*)
            ],
        ], [
            // Pesan error custom agar mahasiswa tidak bingung
            'nim.exists' => 'NIM Anda tidak terdaftar di data Master Kampus!',
            'nim.unique' => 'NIM ini sudah didaftarkan/diklaim oleh akun lain!',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.max' => 'Kata sandi tidak boleh lebih dari 12 karakter.'
        ]);

        // 2. AMBIL DATA NAMA ASLI DARI MASTER
        $masterData = MasterMahasiswa::where('nim', $request->nim)->first();

        // 3. KEAMANAN EKSTRA: Cek apakah statusnya sudah diklaim?
        if ($masterData->is_registered) {
            return back()->withInput()->withErrors(['nim' => 'NIM ini sudah diaktivasi. Silakan hubungi Admin jika ini adalah kesalahan.']);
        }

        // 4. BUAT AKUN MAHASISWA
        $user = User::create([
            'name' => $masterData->nama_lengkap, // Tarik nama otomatis dari Admin
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default sebagai mahasiswa
        ]);

        // 5. KUNCI STATUS NIM DI MASTER DATA (Tandai sudah daftar)
        $masterData->update([
            'is_registered' => true
        ]);

        // 6. LOGIN OTOMATIS & LEMPAR KE DASHBOARD
        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}