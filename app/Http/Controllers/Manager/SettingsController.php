<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    // Menampilkan Halaman Settings
    public function index()
    {
        $user = Auth::user();
        return view('manager.settings', compact('user'));
    }

    // Menyimpan Perubahan Profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed', // Harus cocok dengan password_confirmation
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.'
        ]);

        // Update nama dan email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password HANYA JIKA diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}