<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Manager\SettingsController;
use App\Http\Controllers\Finance\FinanceController;

// Arahkan halaman utama langsung ke login
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});
Route::get('/verify-otp', function () { 
    return view('auth.verify-otp'); });
Route::get('/reset-password', function () { 
    return view('auth.reset-password'); }); 
Route::middleware(['auth'])->group(function () {
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{id}/process', [ApprovalController::class, 'process'])->name('approvals.process');
    Route::get('/approvals/{id}/detail', [ApprovalController::class, 'show'])->name('approvals.show');
    
    Route::post('/approvals/{id}/process', [ApprovalController::class, 'process'])->name('approvals.process');
});
// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rute khusus ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('admin.users.index');
    Route::get('/kelola-data', function () {
    return view('admin.kelola-data');
    })->name('admin.kelola.data');
    Route::get('/api/users', [UserController::class, 'index']);
    Route::post('/api/users', [UserController::class, 'store']);
    Route::get('/api/users/{id}', [UserController::class, 'show']);
    Route::put('/api/users/{id}', [UserController::class, 'update']);
    Route::delete('/api/users/{id}', [UserController::class, 'destroy']);
    Route::get('/settings', function () {
    return view('admin.settings');
    })->name('admin.settings');
    Route::get('/riwayat-perubahan', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.riwayat.perubahan');
});

// Rute khusus STAFF
Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    
    // Rute pendaratan utama untuk Staff
    Route::get('/absensi', function () {
        return view('staff.dashboard');
    })->name('staff.absensi');

    // Rute alternatif (opsional)
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');
    Route::get('/pengajuan', function () {
    return view('staff.pengajuan');
    })->name('staff.pengajuan.create');
    Route::get('/pengajuan', function () {
    $users = User::orderBy('name', 'asc')->get();
    return view('staff.pengajuan', compact('users'));
    })->name('staff.pengajuan.create');
    Route::get('/settings', function () {
        return view('staff.settings');
    })->name('staff.settings');
    Route::get('/pengajuan/detail', function () {
        return view('staff.pengajuan-detail');
    })->name('staff.pengajuan.detail');
    Route::post('/pengajuan', function (\Illuminate\Http\Request $request) {    
        return redirect()->route('staff.pengajuan.detail');
    })->name('staff.pengajuan.store');
    // Rute MENAMPILKAN Riwayat Pengajuan
    Route::get('/riwayat', function () {
        // Mengambil semua pengajuan milik user yang sedang login, diurutkan dari yang terbaru
        $requests = \App\Models\TravelRequest::where('user_id', \Illuminate\Support\Facades\Auth::id())
                        ->latest()
                        ->get();
        return view('staff.riwayat', compact('requests'));
    })->name('staff.riwayat');
    
    Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('staff.pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('staff.pengajuan.store');
    
    Route::get('/pengajuan/detail', function () {
        return view('staff.pengajuan-detail');
    })->name('staff.pengajuan.detail');
    Route::get('/pengajuan/{id}/pdf', [\App\Http\Controllers\PengajuanController::class, 'cetakPDF'])->name('staff.pengajuan.pdf');
    // Rute Lacak Pengajuan SPPD (Tracking)
    Route::get('/pengajuan/{id}/track', [\App\Http\Controllers\PengajuanController::class, 'track'])->name('staff.pengajuan.track');
});

// Rute khusus MANAGER
Route::middleware(['auth', 'role:manager,hrd,kepala marketing'])->prefix('manager')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');

    Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('staff.pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('staff.pengajuan.store');
    Route::get('/settings', [SettingsController::class, 'index'])->name('manager.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('manager.settings.update');
    Route::get('/pengajuan/detail', function () {
        return view('staff.pengajuan-detail');
    })->name('staff.pengajuan.detail');
});
// Rute khusus FINANCE (Level 2)
Route::middleware(['auth', 'role:finance'])->prefix('finance')->group(function () {
    
    Route::get('/dashboard', [FinanceController::class, 'index'])->name('finance.dashboard');
    
    // Rute settings finance akan kita buat menyusul jika diperlukan
    // Route::get('/settings', [FinanceSettingsController::class, 'index'])->name('finance.settings');
});
