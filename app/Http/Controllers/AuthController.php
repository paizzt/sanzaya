<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        // Jika user sudah login, langsung arahkan ke dashboard masing-masing
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }
        return view('auth.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Arahkan berdasarkan role
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    // Fungsi bantuan untuk mengarahkan rute berdasarkan role
    private function redirectBasedOnRole($role)
    {
        // Fitur Keamanan: Ubah huruf menjadi kecil semua agar terhindar dari error 
        // jika Admin mengetik "Finance" (huruf F besar) atau "Staff".
        $role = strtolower($role);

        switch ($role) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
                
            case 'manager':
            case 'hrd':
            case 'kepala marketing':
                // Semua role Level 1 diarahkan ke Dashboard Manajer
                return redirect()->intended('/manager/dashboard');
                
            case 'finance':
                // Arahkan role finance ke Dashboard khusus Finance (Level 2)
                return redirect()->intended('/finance/dashboard');
                
            case 'staff':
                // Memastikan staff masuk ke rutenya sendiri
                return redirect()->intended('/staff/dashboard');
                
            default:
                // Jika rolenya sama sekali tidak dikenali, keluarkan paksa
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Role/Jabatan akun Anda tidak dikenali oleh sistem.']);
        }
    }
}