<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route($this->getDashboardRoute());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // ============================================
        // CARI USER TERLEBIH DAHULU
        // ============================================
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => 'Username tidak ditemukan.',
            ]);
        }

        // ============================================
        // CEK APAKAH USER AKTIF
        // ============================================
        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'username' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ]);
        }

        // ============================================
        // CEK PASSWORD DENGAN BCRYPT
        // ============================================
        
        // 1. Coba dengan Auth::attempt (standar Laravel)
        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'is_active' => true,
        ], $request->boolean('remember'))) {
            
            $request->session()->regenerate();
            Auth::user()->update(['last_login_at' => now()]);
            return redirect()->route($this->getDashboardRoute());
        }

        // 2. Jika Auth::attempt gagal, cek apakah password plain text
        if (Hash::check($credentials['password'], $user->password)) {
            // Password valid, update dengan hash Bcrypt
            $user->password = Hash::make($credentials['password']);
            $user->save();
            
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            $user->update(['last_login_at' => now()]);
            
            return redirect()->route($this->getDashboardRoute());
        }

        // 3. Jika masih plain text (belum di-hash sama sekali)
        if ($credentials['password'] === $user->password) {
            $user->password = Hash::make($credentials['password']);
            $user->save();
            
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            $user->update(['last_login_at' => now()]);
            
            return redirect()->route($this->getDashboardRoute());
        }

        // 4. Jika semua gagal
        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function getDashboardRoute(): string
    {
        $user = Auth::user();
        
        if (!$user) {
            return 'login';
        }

        return match ($user->role) {
            'admin' => 'admin.dashboard',
            'petugas_loket' => 'loket.dashboard',
            'kutipan_kedua' => 'kutipan-kedua.dashboard',
            'keabsahan' => 'keabsahan.dashboard',
            'surat_pengantar' => 'surat-pengantar.dashboard',
            default => 'login',
        };
    }
}