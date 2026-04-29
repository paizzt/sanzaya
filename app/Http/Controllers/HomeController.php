<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Mengarahkan user ke dashboard masing-masing sesuai jabatannya (role)
     */
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = strtolower(trim(Auth::user()->role));

        // Arahkan berdasarkan role
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
            
        } elseif (in_array($role, ['manager', 'hrd', 'kepala marketing'])) {
            return redirect()->route('manager.dashboard');
            
        } elseif ($role === 'finance') {
            return redirect()->route('finance.dashboard');
            
        } else {
            // Default jika role adalah 'staff' atau lainnya
            return redirect()->route('staff.dashboard');
        }
    }
}