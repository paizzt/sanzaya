<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Validasi ketat sesuai pilihan dropdown Anda
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,staff,manager,hrd,kepala marketing,finance',
            'division' => 'required|in:Finance,GA,Logistik,Marketing,Cleaning Service,Manajemen,IT,HRD',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->birth_place = $request->birth_place;
        $user->birth_date = $request->birth_date;
        $user->division = $request->division;
        $user->nik = $request->nik;
        $user->employee_id = $request->employee_id;

        // Menyimpan data Bank
        $user->nama_rekening = $request->nama_rekening;
        $user->nomor_rekening = $request->nomor_rekening;
        $user->bank = $request->bank;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        } else {
            $user->password = Hash::make('12345678');
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna berhasil ditambahkan!'
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:admin,staff,manager,hrd,kepala marketing,finance',
            'division' => 'required|in:Finance,GA,Logistik,Marketing,Cleaning Service,Manajemen,IT,HRD',
        ]);

        $user->update($request->except('password')); 

        return response()->json(['message' => 'Berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Berhasil dihapus!']);
    }
}