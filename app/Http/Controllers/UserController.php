<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            // Validasi 'in' memastikan role yang diinput harus sesuai dengan pilihan
            'role'        => 'required|in:hrd,manajemen,kepala marketing,finance',
            
            // 'nullable' berarti tidak wajib diisi
            'nik'         => 'nullable|string|max:16|unique:users,nik', 
            'employee_id' => 'nullable|string|unique:users,employee_id',
            
            'phone'       => 'nullable|string|max:20',
            'birth_place' => 'nullable|string|max:255',
            'birth_date'  => 'nullable|date',
            'division'    => 'nullable|string|max:255',
            
            // Password boleh kosong dari form
            'password'    => 'nullable|string|min:8',
        ]);

        // 2. Logika Password Default
        // Cek apakah field password diisi oleh user
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            // Jika kosong, setel password default menjadi 12345678
            $validatedData['password'] = Hash::make('12345678');
        }

        // 3. Simpan Data ke Database
        User::create($validatedData);

        // 4. Kembalikan respons sukses (berupa JSON agar bisa ditangkap oleh JavaScript)
        return response()->json([
            'status'  => 'success',
            'message' => 'Pengguna berhasil ditambahkan.'
        ]);
        // Saat Admin membuat user baru
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Tambah Pengguna',
            'description' => 'Admin menambahkan akun baru dengan nama: ' . $userBaru->name,
            'target_type' => 'User'
        ]);

        // Saat Admin menghapus user
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Hapus Pengguna',
            'description' => 'Admin menghapus akun pengguna: ' . $userLama->name,
            'target_type' => 'User'
        ]);
    }
}