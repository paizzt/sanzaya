<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- CONTROLLERS ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Manager\SettingsController as ManagerSettingsController;
use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\Admin\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama & Auth
Route::get('/', function () { return redirect('/login'); });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Redirect Selepas Login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Halaman Lupa Password & OTP
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.request');
Route::get('/verify-otp', function () { return view('auth.verify-otp'); })->name('otp.verify');
Route::get('/reset-password', function () { return view('auth.reset-password'); })->name('password.reset'); 

/*
|--------------------------------------------------------------------------
| RUTE BERSAMA (Diakses oleh semua yang sudah Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Pusat Persetujuan (Manager & Finance)
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::get('/approvals/{id}', [ApprovalController::class, 'show'])->name('approvals.show');
    Route::post('/approvals/{id}/process', [ApprovalController::class, 'process'])->name('approvals.process');
    
    // Fitur Dokumen & Tracking
    Route::get('/pengajuan/{id}/pdf', [PengajuanController::class, 'cetakPDF'])->name('pengajuan.cetak');
    Route::get('/pengajuan/{id}/track', [PengajuanController::class, 'track'])->name('staff.pengajuan.track');
    Route::get('/arsip', function () {
        return view('shared.arsip');
    })->name('arsip.index')->middleware('role:manager,hrd,kepala marketing,finance,admin');
});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS ADMINISTRATOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    
    // Kelola User (View & API)
    Route::get('/users', function () { return view('admin.users.index'); })->name('admin.users.index');
    Route::get('/kelola-data', function () { return view('admin.kelola-data'); })->name('admin.kelola.data');
    Route::get('/api/users', [UserController::class, 'index']);
    Route::post('/api/users', [UserController::class, 'store']);
    Route::get('/api/users/{id}', [UserController::class, 'show']);
    Route::put('/api/users/{id}', [UserController::class, 'update']);
    Route::delete('/api/users/{id}', [UserController::class, 'destroy']);

    // Logs & Settings
    Route::get('/riwayat-perubahan', [ActivityLogController::class, 'index'])->name('admin.riwayat.perubahan');
    Route::get('/settings', function () { return view('admin.settings'); })->name('admin.settings');
    Route::post('/settings', [AuthController::class, 'updateProfile'])->name('admin.settings.update'); // Tambah rute simpan
});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS STAFF
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', function () { return view('staff.dashboard'); })->name('staff.dashboard');
    
    // Pengajuan UC
    Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('staff.pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('staff.pengajuan.store');
    Route::get('/riwayat', function () { 
        $requests = \App\Models\TravelRequest::where('user_id', Auth::id())->latest()->get();
        return view('staff.riwayat', compact('requests')); 
    })->name('staff.riwayat');

    // Settings
    Route::get('/settings', function () { return view('staff.settings'); })->name('staff.settings');
    Route::post('/settings', [AuthController::class, 'updateProfile'])->name('staff.settings.update');
});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS MANAGER / HRD / KEPALA MARKETING
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager,hrd,kepala marketing'])->prefix('manager')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/history', function () { return view('manager.history'); })->name('manager.history');
    
    // Manager juga boleh buat pengajuan (Direct to Finance)
    Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('manager.pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('manager.pengajuan.store');

    // Settings
    Route::get('/settings', [ManagerSettingsController::class, 'index'])->name('manager.settings');
    Route::post('/settings', [ManagerSettingsController::class, 'update'])->name('manager.settings.update');
});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS FINANCE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:finance'])->prefix('finance')->group(function () {
    Route::get('/dashboard', [FinanceController::class, 'index'])->name('finance.dashboard');
    Route::get('/history', function () { return view('finance.history'); })->name('finance.history');
    
    // Settings
    Route::get('/settings', function () { return view('finance.settings'); })->name('finance.settings');
    Route::post('/settings', [AuthController::class, 'updateProfile'])->name('finance.settings.update');
});