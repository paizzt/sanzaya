<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Data Pengguna - Satu Sanzaya</title>
    
    <!-- Modern Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        },
                        surface: '#f8fafc',
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 20px rgba(59, 130, 246, 0.5)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar for a premium feel */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Hide scrollbar for sidebar but allow scrolling */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Smooth transitions */
        .transition-all-ease { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        /* --- DESKTOP COLLAPSE SIDEBAR STYLES --- */
        @media (min-width: 1024px) {
            .sidebar.collapsed { width: 88px !important; }
            .sidebar.collapsed .menu-text,
            .sidebar.collapsed .sidebar-title,
            .sidebar.collapsed .badge-count { display: none; opacity: 0; }
            .sidebar.collapsed .menu-item { justify-content: center; padding-left: 0; padding-right: 0; margin-left: 0.75rem; margin-right: 0.75rem; }
            .sidebar.collapsed .menu-item i { margin-right: 0 !important; }
            .sidebar.collapsed .logo-img { max-width: 40px; }
        }
    </style>
</head>
<body class="bg-surface text-slate-800 font-sans antialiased overflow-hidden flex h-screen">

    <!-- MENGAMBIL DATA NOTIFIKASI ADMIN (Riwayat Aktivitas Terbaru) -->
    @php
        $notifications = collect();
        $hasNewNotif = false;
        
        if(class_exists('\App\Models\ActivityLog')) {
            $notifications = \App\Models\ActivityLog::with('user')->latest()->take(5)->get();
            $hasNewNotif = $notifications->count() > 0;
        }
    @endphp

    <!-- MOBILE OVERLAY -->
    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar bg-white w-[280px] h-full border-r border-slate-200 flex flex-col transition-all-ease fixed lg:relative z-50 -translate-x-full lg:translate-x-0 shadow-2xl lg:shadow-none">
        
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-center border-b border-slate-100 px-6 logo-area overflow-hidden">
            <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center group">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img max-w-[140px] group-hover:scale-105 transition-all-ease">
            </a>
            <button id="closeSidebarBtn" class="lg:hidden absolute right-4 text-slate-400 hover:text-slate-800">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto no-scrollbar py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-border-all w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-clock-rotate-left w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Riwayat Perubahan</span>
            </a>
            
            <a href="{{ route('admin.users.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                <i class="fas fa-users w-5 text-center text-lg mr-3"></i>
                <span class="menu-text">Kelola Data</span>
            </a>
            
            <a href="{{ route('arsip.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-archive w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Arsip Seluruh Sistem</span>
            </a>

            <div class="pt-4 pb-2">
                <div class="border-t border-slate-100"></div>
            </div>
            
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>

            <a href="{{ route('admin.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Pengaturan Akun</span>
            </a>
        </div>

        <div class="p-4 border-t border-slate-100">
            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">@csrf</form>
            <button onclick="document.getElementById('logout-form').submit();" class="menu-item flex items-center px-4 py-3 w-full rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600 font-medium transition-all-ease group">
                <i class="fas fa-sign-out-alt w-5 text-center text-lg mr-3 group-hover:-translate-x-1 transition-transform"></i>
                <span class="menu-text">Keluar Sistem</span>
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full w-full overflow-hidden bg-surface relative transition-all-ease">
        
        <!-- GLASSMORPHISM NAVBAR -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-30 flex items-center justify-between px-6 lg:px-10 transition-all-ease">
            
            <div class="flex items-center gap-4 nav-left">
                <button id="openSidebarBtn" class="hamburger-btn text-slate-500 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100 transition-colors outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-slate-800">Manajemen Pengguna</h1>
                </div>
            </div>

            <div class="flex items-center gap-4 lg:gap-6 nav-right">
                <!-- NOTIFICATION BELL WITH PING -->
                <div class="relative z-50 nav-icon">
                    <button id="notifBtn" class="relative p-2.5 text-slate-400 hover:text-brand-600 bg-slate-50 hover:bg-brand-50 rounded-full transition-all-ease focus:outline-none">
                        <i class="far fa-bell text-xl"></i>
                        @if($hasNewNotif)
                            <span class="absolute top-2 right-2.5 flex h-2.5 w-2.5 badge-dot">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border-2 border-white"></span>
                            </span>
                        @endif
                    </button>

                    <!-- DROPDOWN NOTIFIKASI -->
                    <div id="notifDropdown" class="absolute right-0 mt-3 w-80 bg-white/95 backdrop-blur-xl border border-slate-100 rounded-2xl shadow-xl opacity-0 invisible transform translate-y-[-10px] transition-all duration-300 ease-out notification-dropdown">
                        <div class="p-4 border-b border-slate-100 flex justify-between items-center notification-header">
                            <h3 class="font-semibold text-slate-800">Notifikasi Terkini</h3>
                            @if($hasNewNotif)
                                <span class="text-xs bg-brand-100 text-brand-700 font-bold px-2 py-1 rounded-md">{{ $notifications->count() }} Baru</span>
                            @endif
                        </div>
                        <div class="max-h-[320px] overflow-y-auto no-scrollbar notification-list">
                            @forelse($notifications as $log)
                                <div class="flex items-start gap-4 p-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group notification-item">
                                    <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-500 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-100 transition-colors notification-icon">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <div class="flex-1 min-w-0 notification-content">
                                        <p class="text-sm text-slate-700 leading-snug mb-1"><strong>{{ $log->user->name ?? 'Sistem' }}</strong>: {{ $log->description }}</p>
                                        <p class="text-xs text-slate-400"><i class="far fa-clock mr-1"></i><span>{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</span></p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center notification-item">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300 notification-icon">
                                        <i class="fas fa-check-circle text-2xl"></i>
                                    </div>
                                    <p class="text-sm text-slate-500 font-medium notification-content">Belum ada riwayat aktivitas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- USER PROFILE -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200 user-profile">
                    <div class="hidden sm:block text-right user-info">
                        <p class="text-sm font-bold text-slate-800 leading-tight user-name">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs font-medium text-slate-500 capitalize user-role">{{ Auth::user()->role ?? 'admin' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-600 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md border-2 border-white ring-2 ring-slate-100 user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 no-scrollbar content-area relative">
            
            <!-- FILTER CARD -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft mb-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="col-span-1 md:col-span-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Pengguna</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" placeholder="Ketik kata kunci...">
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Filter Jabatan</label>
                        <select id="roleFilter" onchange="filterTable()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white appearance-none">
                            <option value="">Semua Jabatan</option>
                            <option value="manager">Manajer</option>
                            <option value="finance">Finance</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff Biasa</option>
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Urutkan</label>
                        <select class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white appearance-none">
                            <option value="asc">A - Z</option>
                            <option value="desc">Z - A</option>
                            <option value="new">Terbaru</option>
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <button type="button" onclick="resetForm()" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Tambah Pengguna
                        </button>
                    </div>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-soft overflow-hidden flex flex-col">
                
                <div class="px-6 py-5 border-b border-slate-100 flex items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2 m-0 text-base">
                        <span class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center">
                            <i class="fas fa-users text-sm"></i>
                        </span>
                        Daftar Identitas Karyawan
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="bg-white border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <th class="p-5 w-[30%]">Informasi Pengguna</th>
                                <th class="p-5 w-[20%]">NIK / No. Karyawan</th>
                                <th class="p-5 w-[20%]">Divisi & Jabatan</th>
                                <th class="p-5 w-[30%]">Kontak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50" id="tableBody">
                            <!-- Data akan dimuat dari JS melalui fetchUsers() -->
                            <tr>
                                <td colspan="4" class="p-10 text-center text-slate-400">
                                    <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                                    <p class="mt-2">Memuat Data Karyawan...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- CUSTOM TAILWIND SLIDE-OVER PANEL -->
    <div id="userPanelOverlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[60] hidden opacity-0 transition-opacity duration-300" onclick="closeUserPanel()"></div>
    
    <div id="userPanel" class="fixed inset-y-0 right-0 z-[70] w-full max-w-md bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        
        <!-- Header Panel -->
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/80 backdrop-blur-md">
            <h5 class="font-bold text-lg text-slate-800" id="panelTitle">Tambah Pengguna Baru</h5>
            <button type="button" onclick="closeUserPanel()" class="text-slate-400 hover:text-rose-500 transition-colors focus:outline-none p-2 rounded-lg hover:bg-rose-50">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Body Panel -->
        <div class="flex-1 overflow-y-auto p-6 no-scrollbar">
            <form id="formPengguna" onsubmit="event.preventDefault();">
                <input type="hidden" id="userId" name="user_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tempat Lahir</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="birth_place" placeholder="Kota lahir">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                        <input type="date" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="birth_date">
                    </div>
                    
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIK (KTP)</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="nik" placeholder="16 Digit NIK">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Karyawan</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="employee_id" placeholder="Contoh: EMP-001">
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Divisi <span class="text-rose-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 appearance-none disabled:bg-slate-100 disabled:text-slate-400" name="division" required>
                            <option value="">-- Pilih Divisi --</option>
                            <option value="Finance">Finance</option>
                            <option value="GA">GA</option>
                            <option value="Logistik">Logistik</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Cleaning Service">Cleaning Service</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="IT">IT</option>
                            <option value="HRD">HRD</option>
                        </select>
                    </div>
                    
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jabatan <span class="text-rose-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 appearance-none disabled:bg-slate-100 disabled:text-slate-400" name="role" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="manager">Manajer</option>
                            <option value="finance">Finance</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff Biasa</option>
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email <span class="text-rose-500">*</span></label>
                        <input type="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="email" placeholder="nama@sanzaya.com" required>
                    </div>
                    
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Handphone</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="phone" placeholder="08xxx">
                    </div>

                    <!-- INFORMASI REKENING BANK -->
                    <div class="col-span-1 md:col-span-2 mt-4">
                        <h6 class="font-bold text-brand-600 mb-2 flex items-center gap-2"><i class="fas fa-university"></i> Rekening Bank</h6>
                        <hr class="border-slate-100 mb-4">
                    </div>
                    
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bank</label>
                        <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 appearance-none disabled:bg-slate-100 disabled:text-slate-400" name="bank">
                            <option value="">Pilih Bank</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                            <option value="BSI">BSI</option>
                            <option value="CIMB Niaga">CIMB Niaga</option>
                            <option value="Lainnya">Lainnya...</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Rekening</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="nomor_rekening" placeholder="Contoh: 12345678">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Atas Nama</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="nama_rekening" placeholder="Sesuai buku">
                    </div>

                    <div class="col-span-1 md:col-span-2 mt-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Sistem</label>
                        <input type="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 disabled:bg-slate-100 disabled:text-slate-400" name="password" placeholder="Kosongkan untuk password default: 12345678">
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Footer Panel -->
        <div class="p-6 border-t border-slate-100 bg-slate-50/80 backdrop-blur-md" id="actionButtons">
            <!-- Tombol akan dimuat secara dinamis melalui JS -->
        </div>
    </div>

    <!-- INTERACTIVE SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // --- SETUP CSRF TOKEN UNTUK AJAX ---
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- Variabel Slide-over Panel ---
        const userPanel = document.getElementById('userPanel');
        const userPanelOverlay = document.getElementById('userPanelOverlay');

        function openUserPanel() {
            userPanelOverlay.classList.remove('hidden');
            setTimeout(() => {
                userPanelOverlay.classList.remove('opacity-0');
                userPanelOverlay.classList.add('opacity-100');
                userPanel.classList.remove('translate-x-full');
            }, 10);
        }

        function closeUserPanel() {
            userPanel.classList.add('translate-x-full');
            userPanelOverlay.classList.remove('opacity-100');
            userPanelOverlay.classList.add('opacity-0');
            setTimeout(() => {
                userPanelOverlay.classList.add('hidden');
            }, 300);
        }

        // --- LOGIKA NOTIFIKASI DROPDOWN ---
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');
        const badgeDot = document.querySelector('.badge-dot');

        if(notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = notifDropdown.classList.contains('invisible');
                if (isHidden) {
                    notifDropdown.classList.remove('invisible', 'opacity-0', 'translate-y-[-10px]');
                    notifDropdown.classList.add('opacity-100', 'translate-y-0');
                    if(badgeDot) badgeDot.style.display = 'none'; // hide ping
                } else {
                    closeNotif();
                }
            });

            function closeNotif() {
                notifDropdown.classList.remove('opacity-100', 'translate-y-0');
                notifDropdown.classList.add('opacity-0', 'translate-y-[-10px]');
                setTimeout(() => notifDropdown.classList.add('invisible'), 300);
            }

            window.addEventListener('click', (e) => {
                if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) closeNotif();
            });
        }

        // --- LOGIKA SIDEBAR ---
        const sidebar = document.getElementById('sidebar');
        const openSidebarBtn = document.getElementById('openSidebarBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const mobileOverlay = document.getElementById('mobileOverlay');

        if(openSidebarBtn) {
            openSidebarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (window.innerWidth < 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.remove('hidden');
                    setTimeout(() => mobileOverlay.classList.replace('opacity-0', 'opacity-100'), 10);
                } else {
                    sidebar.classList.toggle('collapsed');
                }
            });
        }

        function closeSidebar() {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.replace('opacity-100', 'opacity-0');
                setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
            }
        }
        if(closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
        if(mobileOverlay) mobileOverlay.addEventListener('click', closeSidebar);

        // --- LOAD DATA TABEL (AJAX) ---
        async function fetchUsers() {
            try {
                const response = await fetch('/admin/api/users');
                const users = await response.json();
                let tableBody = document.getElementById('tableBody');
                tableBody.innerHTML = ''; 

                if (users.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="p-10 text-center text-slate-500">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-2xl mx-auto mb-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <p class="text-sm font-medium">Belum ada data pengguna.</p>
                            </td>
                        </tr>
                    `;
                    return;
                }

                users.forEach(user => {
                    // Penentuan Warna Badge Jabatan ala Tailwind
                    let badgeClass = 'bg-brand-50 text-brand-600 border border-brand-200/50';
                    if(user.role === 'admin') badgeClass = 'bg-rose-50 text-rose-600 border border-rose-200/50';
                    if(user.role === 'finance') badgeClass = 'bg-purple-50 text-purple-600 border border-purple-200/50';
                    if(user.role === 'manager') badgeClass = 'bg-emerald-50 text-emerald-600 border border-emerald-200/50';
                    
                    let row = `
                        <tr class="hover:bg-brand-50/50 transition-colors duration-200 cursor-pointer group" onclick="loadDetailData(${user.id})">
                            <td class="p-5 align-middle border-b border-slate-50">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm flex-shrink-0 group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                                        ${user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm mb-0.5 leading-tight">${user.name}</p>
                                        <span class="text-xs font-medium text-slate-500">${user.birth_place || '-'}, ${user.birth_date || '-'}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5 align-middle border-b border-slate-50">
                                <p class="font-bold text-slate-700 text-sm mb-0.5 leading-tight">${user.nik || '-'}</p>
                                <span class="text-xs font-medium text-slate-500">${user.employee_id || '-'}</span>
                            </td>
                            <td class="p-5 align-middle border-b border-slate-50">
                                <p class="mb-1"><span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider shadow-sm ${badgeClass}">${user.role}</span></p>
                                <span class="text-xs font-medium text-slate-500">${user.division || '-'}</span>
                            </td>
                            <td class="p-5 align-middle border-b border-slate-50">
                                <p class="text-xs font-medium text-slate-600 mb-1 flex items-center gap-2"><i class="fas fa-envelope text-slate-400 w-3 text-center"></i> ${user.email}</p>
                                <p class="text-xs font-medium text-slate-600 m-0 flex items-center gap-2"><i class="fas fa-phone text-slate-400 w-3 text-center"></i> ${user.phone || '-'}</p>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            } catch (error) { 
                console.error("Gagal memuat data tabel:", error); 
                document.getElementById('tableBody').innerHTML = `
                    <tr><td colspan="4" class="p-10 text-center text-rose-500 font-bold">Gagal memuat data dari server.</td></tr>
                `;
            }
        }

        // Panggil data saat halaman terbuka
        document.addEventListener('DOMContentLoaded', fetchUsers);

        // --- FILTER LOCAL PENCARIAN & JABATAN ---
        function filterTable() {
            let searchKeyword = document.getElementById('searchInput').value.toLowerCase();
            let roleKeyword = document.getElementById('roleFilter').value.toLowerCase();
            let tableRows = document.querySelectorAll('#tableBody tr');

            tableRows.forEach(row => {
                if(row.cells.length > 1) { // Skip jika baris "Memuat data"
                    let textData = row.innerText.toLowerCase();
                    let roleData = row.cells[2].innerText.toLowerCase();

                    let matchSearch = textData.includes(searchKeyword);
                    let matchRole = roleKeyword === "" || roleData.includes(roleKeyword);

                    if (matchSearch && matchRole) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        // --- MODE: TAMBAH DATA BARU ---
        function resetForm() {
            try {
                document.getElementById('panelTitle').innerText = 'Tambah Pengguna Baru';
                document.getElementById('formPengguna').reset();
                document.getElementById('userId').value = ''; 
                
                document.querySelectorAll('#formPengguna input, #formPengguna select').forEach(el => el.disabled = false);

                document.getElementById('actionButtons').innerHTML = `
                    <div class="flex justify-between items-center w-full">
                        <button type="button" class="bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-800 font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-2" onclick="closeUserPanel()">
                            Batal
                        </button>
                        <button type="button" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2" onclick="submitData()">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                    </div>
                `;

                openUserPanel();
            } catch (error) {
                console.error("Terjadi kesalahan saat membuka form:", error);
            }
        }

        // --- MODE: LIHAT DETAIL ---
        async function loadDetailData(id) {
            document.getElementById('panelTitle').innerText = 'Memuat Data...';
            
            // Tampilkan panel
            openUserPanel();
            
            try {
                const response = await fetch(`/admin/api/users/${id}`);
                const user = await response.json();

                document.getElementById('panelTitle').innerText = 'Detail Pengguna';
                document.getElementById('userId').value = user.id;

                // Isi Form
                document.querySelector('[name="name"]').value = user.name || '';
                document.querySelector('[name="email"]').value = user.email || '';
                document.querySelector('[name="role"]').value = user.role || '';
                document.querySelector('[name="nik"]').value = user.nik || '';
                document.querySelector('[name="employee_id"]').value = user.employee_id || '';
                document.querySelector('[name="division"]').value = user.division || '';
                document.querySelector('[name="phone"]').value = user.phone || '';
                document.querySelector('[name="birth_place"]').value = user.birth_place || '';
                document.querySelector('[name="birth_date"]').value = user.birth_date || '';
                
                // Isi Form Rekening Bank
                document.querySelector('[name="bank"]').value = user.bank || '';
                document.querySelector('[name="nomor_rekening"]').value = user.nomor_rekening || '';
                document.querySelector('[name="nama_rekening"]').value = user.nama_rekening || '';
                
                document.querySelector('[name="password"]').value = ''; // Kosongkan saat view
                
                // Kunci Input (Mode Lihat/View)
                document.querySelectorAll('#formPengguna input, #formPengguna select').forEach(el => el.disabled = true);

                document.getElementById('actionButtons').innerHTML = `
                    <div class="flex justify-between items-center w-full">
                        <div class="flex gap-3">
                            <button type="button" class="bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-800 font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm" onclick="closeUserPanel()">
                                Tutup
                            </button>
                            <button type="button" class="bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 hover:text-rose-700 font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-2" onclick="deleteUser(${user.id})" title="Hapus">
                                <i class="far fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                        <button type="button" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2" onclick="enableEditMode()">
                            <i class="fas fa-pencil-alt"></i> Edit Data
                        </button>
                    </div>
                `;
            } catch (error) { 
                closeUserPanel();
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menarik data dari server.', customClass: { popup: 'rounded-2xl' } }); 
            }
        }

        // --- MODE: EDIT DATA ---
        function enableEditMode() {
            document.getElementById('panelTitle').innerText = 'Edit Data Pengguna';
            
            // Buka kunci semua input
            document.querySelectorAll('#formPengguna input, #formPengguna select').forEach(el => {
                el.disabled = false;
            });

            document.getElementById('actionButtons').innerHTML = `
                <div class="flex justify-between items-center w-full">
                    <button type="button" class="bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-800 font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm" onclick="loadDetailData(document.getElementById('userId').value)">
                        Batal
                    </button>
                    <button type="button" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2" onclick="submitData()">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            `;
        }

        // --- AKSI: SIMPAN / UPDATE ---
        async function submitData() {
            let form = document.getElementById('formPengguna');
            if(!form.checkValidity()) { form.reportValidity(); return; }

            let formData = new FormData(form);
            let userId = document.getElementById('userId').value;
            let url = userId ? `/admin/api/users/${userId}` : '/admin/api/users';
            
            if(userId) formData.append('_method', 'PUT'); 

            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); },
                customClass: { popup: 'rounded-2xl' }
            });

            try {
                const response = await fetch(url, {
                    method: 'POST', 
                    body: formData,
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest', 
                        'X-CSRF-TOKEN': csrfToken 
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    closeUserPanel();
                    fetchUsers();
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Berhasil!', 
                        text: 'Data disimpan.', 
                        showConfirmButton: false, 
                        timer: 1500,
                        customClass: { popup: 'rounded-2xl' }
                    });
                } else {
                    let errorMsg = 'Gagal menyimpan data.';
                    if (response.status === 422 && result.errors) errorMsg = Object.values(result.errors)[0][0]; 
                    else if (result.message) errorMsg = result.message;
                    Swal.fire({ icon: 'error', title: 'Gagal', text: errorMsg, customClass: { popup: 'rounded-2xl' } });
                }
            } catch (error) { 
                Swal.fire({ icon: 'error', title: 'Kesalahan Sistem', text: 'Gagal menghubungi server.', customClass: { popup: 'rounded-2xl' } });
            }
        }

        // --- AKSI: HAPUS ---
        async function deleteUser(id) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                text: "Data karyawan yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: '<span class="text-slate-600">Batal</span>',
                customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
                    try {
                        const response = await fetch(`/admin/api/users/${id}`, {
                            method: 'DELETE',
                            headers: { 
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (response.ok) {
                            closeUserPanel();
                            fetchUsers();
                            Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Pengguna telah dihapus.', showConfirmButton: false, timer: 1500, customClass: { popup: 'rounded-2xl' } });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Pengguna gagal dihapus.', customClass: { popup: 'rounded-2xl' } });
                        }
                    } catch (error) { 
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Kesalahan server.', customClass: { popup: 'rounded-2xl' } });
                    }
                }
            });
        }
    </script>
</body>
</html>