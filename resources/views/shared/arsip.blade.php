<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Sistem - Satu Sanzaya</title>
    
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

    <!-- MENGAMBIL DATA ARSIP DAN NOTIFIKASI OTOMATIS BERDASARKAN ROLE -->
    @php
        $userRole = strtolower(trim(Auth::user()->role));
        
        // Ambil Data Arsip (Sudah di-pass dari Route, tapi jika tidak, fallback ini akan jalan)
        if(!isset($arsip)) {
            $arsip = \App\Models\TravelRequest::with('user')
                        ->whereIn('status', ['approved', 'selesai', 'rejected'])
                        ->orderBy('updated_at', 'desc')
                        ->get();
        }

        // Ambil Data Untuk Notifikasi (Pop-up Bel) menyesuaikan Role
        $notifications = collect();
        $hasNewNotif = false;

        if ($userRole === 'admin') {
            if(class_exists('\App\Models\ActivityLog')) {
                $notifications = \App\Models\ActivityLog::with('user')->latest()->take(5)->get();
                $hasNewNotif = $notifications->count() > 0;
            }
        } elseif (in_array($userRole, ['manager', 'hrd', 'kepala marketing'])) {
            $notifications = \App\Models\TravelRequest::with('user')
                ->where('status', 'pending_l1')
                ->latest()
                ->take(5)
                ->get();
            $hasNewNotif = $notifications->count() > 0;
        } elseif ($userRole === 'finance') {
            $notifications = \App\Models\TravelRequest::with('user')
                ->where('status', 'pending_l2')
                ->latest()
                ->take(5)
                ->get();
            $hasNewNotif = $notifications->count() > 0;
        }
    @endphp

    <!-- MOBILE OVERLAY -->
    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden"></div>

    <!-- SIDEBAR PINTAR (DINAMIS BERDASARKAN ROLE) -->
    <aside id="sidebar" class="sidebar bg-white w-[280px] h-full border-r border-slate-200 flex flex-col transition-all-ease fixed lg:relative z-50 -translate-x-full lg:translate-x-0 shadow-2xl lg:shadow-none">
        
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-center border-b border-slate-100 px-6 logo-area overflow-hidden">
            <a href="{{ url('/home') }}" class="flex items-center group">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img max-w-[140px] group-hover:scale-105 transition-all-ease">
            </a>
            <button id="closeSidebarBtn" class="lg:hidden absolute right-4 text-slate-400 hover:text-slate-800">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto no-scrollbar py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Menu Utama</p>
            
            @if($userRole === 'admin')
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-border-all w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                <a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-clock-rotate-left w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Riwayat Perubahan</span>
                </a>
                <a href="{{ route('admin.users.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-users w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Kelola Data</span>
                </a>
                <a href="{{ route('arsip.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                    <i class="fas fa-archive w-5 text-center text-lg mr-3"></i>
                    <span class="menu-text">Arsip Seluruh Sistem</span>
                </a>

                <div class="pt-4 pb-2"><div class="border-t border-slate-100"></div></div>
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>

                <a href="{{ route('admin.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Settings</span>
                </a>

            @elseif(in_array($userRole, ['manager', 'hrd', 'kepala marketing']))
                <a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-border-all w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                <a href="{{ route('approvals.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-file-signature w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Persetujuan SPPD</span>
                </a>
                <a href="{{ route('manager.history') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-history w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Riwayat Proses</span>
                </a>
                <a href="{{ route('arsip.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                    <i class="fas fa-archive w-5 text-center text-lg mr-3"></i>
                    <span class="menu-text">Arsip UC</span>
                </a>

                <div class="pt-4 pb-2"><div class="border-t border-slate-100"></div></div>
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>

                <a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-paper-plane w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Buat Pengajuan</span>
                </a>
                <a href="{{ route('manager.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Pengaturan Akun</span>
                </a>

            @elseif($userRole == 'finance')
                <a href="{{ route('finance.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-border-all w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                <a href="{{ route('approvals.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-file-invoice-dollar w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Antrean Pencairan</span>
                </a>
                <a href="{{ route('finance.history') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-history w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Riwayat Pencairan</span>
                </a>
                <a href="{{ route('arsip.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                    <i class="fas fa-archive w-5 text-center text-lg mr-3"></i>
                    <span class="menu-text">Arsip UC</span>
                </a>

                <div class="pt-4 pb-2"><div class="border-t border-slate-100"></div></div>
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>

                <a href="{{ route('finance.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Pengaturan Akun</span>
                </a>
            @endif
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
                    <h1 class="text-xl font-bold text-slate-800">Arsip Dokumen SPPD</h1>
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
                            @if($userRole === 'admin')
                                @forelse($notifications as $log)
                                    <div class="flex items-start gap-4 p-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group notification-item">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-colors bg-brand-50 text-brand-500 group-hover:bg-brand-100 notification-icon">
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
                            @else
                                @forelse($notifications as $notif)
                                    @php
                                        $notifClass = in_array($userRole, ['manager', 'hrd', 'kepala marketing']) ? 'bg-amber-50 text-amber-500 group-hover:bg-amber-100' : 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-100';
                                        $notifIcon = in_array($userRole, ['manager', 'hrd', 'kepala marketing']) ? 'fa-file-signature' : 'fa-file-invoice-dollar';
                                        $notifText = in_array($userRole, ['manager', 'hrd', 'kepala marketing'])
                                            ? "Pengajuan UC dari <span class='font-bold text-slate-900'>".($notif->user->name ?? 'Staff')."</span> menunggu persetujuan Anda."
                                            : "Pengajuan UC <span class='font-bold text-slate-900'>".($notif->user->name ?? 'Staff')."</span> menunggu pencairan dana.";
                                    @endphp
                                    <a href="{{ route('approvals.show', $notif->id) }}" class="flex items-start gap-4 p-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group notification-item">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-colors {{ $notifClass }} notification-icon">
                                            <i class="fas {{ $notifIcon }}"></i>
                                        </div>
                                        <div class="flex-1 min-w-0 notification-content">
                                            <p class="text-sm text-slate-700 leading-snug mb-1">{!! $notifText !!}</p>
                                            <p class="text-xs text-slate-400"><i class="far fa-clock mr-1"></i><span>{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span></p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-8 text-center notification-item">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300 notification-icon">
                                            <i class="fas fa-check-circle text-2xl"></i>
                                        </div>
                                        <p class="text-sm text-slate-500 font-medium notification-content">Tidak ada pengajuan baru.</p>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>

                <!-- USER PROFILE -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200 user-profile">
                    <div class="hidden sm:block text-right user-info">
                        <p class="text-sm font-bold text-slate-800 leading-tight user-name">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                        <p class="text-xs font-medium text-slate-500 capitalize user-role">{{ Auth::user()->role ?? 'Role' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-600 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md border-2 border-white ring-2 ring-slate-100 user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-6 lg:p-10 no-scrollbar content-area">

            <!-- FILTER CARD -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft mb-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="col-span-1 md:col-span-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Pegawai</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white" placeholder="Ketik nama pegawai...">
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Filter Status</label>
                        <select class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white appearance-none">
                            <option value="">Semua Arsip</option>
                            <option value="selesai">Selesai 100% (Result & Nota)</option>
                            <option value="approved">Dana Cair (Belum Result)</option>
                            <option value="rejected">Ditolak / Batal</option>
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bulan</label>
                        <input type="month" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white">
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <button class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-sm text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-soft overflow-hidden flex flex-col">
                
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2 m-0 text-base">
                        <span class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center">
                            <i class="fas fa-archive text-sm"></i>
                        </span>
                        Arsip Dokumen Perjalanan Dinas (Lengkap)
                    </h3>
                    <span class="text-xs font-semibold text-slate-500 bg-white px-3 py-1 border border-slate-200 rounded-full shadow-sm">{{ $arsip->count() }} Dokumen</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="bg-white border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <th class="p-5 w-1/4">Pegawai</th>
                                <th class="p-5 w-1/4">Tujuan & Waktu</th>
                                <th class="p-5 w-[15%]">Biaya Disetujui</th>
                                <th class="p-5 w-[20%]">Status Arsip</th>
                                <th class="p-5 w-[15%] text-center">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($arsip as $req)
                                <tr class="hover:bg-brand-50/50 transition-colors duration-200 group">
                                    <td class="p-5 align-middle">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm flex-shrink-0 group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                                                {{ strtoupper(substr($req->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-sm mb-0.5 leading-tight">{{ $req->user->name ?? 'User Terhapus' }}</p>
                                                <p class="text-xs font-medium text-slate-500 capitalize">{{ $req->user->role ?? '' }} {{ $req->user->division ? '• '.$req->user->division : '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5 align-middle">
                                        <p class="font-bold text-slate-800 text-sm mb-0.5 leading-tight flex items-center gap-2">
                                            {{ $req->destination }}
                                        </p>
                                        <p class="text-xs font-medium text-slate-500">
                                            <i class="far fa-calendar-alt text-slate-400 mr-1"></i> 
                                            {{ \Carbon\Carbon::parse($req->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="p-5 align-middle">
                                        @if($req->status != 'rejected')
                                            <p class="font-bold text-emerald-600 text-sm mb-0 leading-tight">Rp {{ number_format($req->total_biaya ?? 0, 0, ',', '.') }}</p>
                                        @else
                                            <p class="text-slate-400 text-sm italic mb-0 leading-tight">-</p>
                                        @endif
                                    </td>
                                    <td class="p-5 align-middle">
                                        @if($req->status == 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600 border border-brand-200/60 shadow-sm">
                                                <i class="fas fa-check-double"></i> Selesai (Ada Result)
                                            </span>
                                        @elseif($req->status == 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60 shadow-sm">
                                                <i class="fas fa-check-circle"></i> Dicairkan (Cek Result)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200/60 shadow-sm">
                                                <i class="fas fa-times-circle"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-5 align-middle text-center flex justify-center gap-2">
                                        <a href="{{ route('approvals.show', $req->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-white border border-slate-200 text-slate-600 hover:text-brand-600 hover:border-brand-300 hover:bg-brand-50 rounded-lg transition-all shadow-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($req->status == 'selesai' || $req->status == 'approved')
                                            <a href="{{ route('pengajuan.cetak', $req->id) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 bg-rose-50 border border-rose-100 text-rose-500 hover:text-white hover:border-rose-500 hover:bg-rose-500 rounded-lg transition-all shadow-sm" title="Download Surat Tugas">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        
                                        @if($req->status == 'selesai')
                                            <a href="{{ route('pengajuan.result.pdf', $req->id) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 bg-brand-50 border border-brand-100 text-brand-600 hover:text-white hover:border-brand-600 hover:bg-brand-600 rounded-lg transition-all shadow-sm" title="Download PDF Result">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 text-3xl mx-auto mb-4">
                                            <i class="fas fa-archive"></i>
                                        </div>
                                        <h4 class="text-slate-700 font-bold mb-1 text-lg">Arsip Kosong</h4>
                                        <p class="text-sm text-slate-500 max-w-md mx-auto">Belum ada dokumen perjalanan dinas yang masuk ke dalam arsip.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- Notification Dropdown Logic ---
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
                        if(badgeDot) badgeDot.style.display = 'none'; // hide ping after viewing
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
                    if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
                        closeNotif();
                    }
                });
            }

            // --- Toggle Sidebar Logic (Mobile & Desktop) ---
            const sidebar = document.getElementById('sidebar');
            const openSidebarBtn = document.getElementById('openSidebarBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');
            const mobileOverlay = document.getElementById('mobileOverlay');

            // Open/Collapse Handler
            if(openSidebarBtn) {
                openSidebarBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (window.innerWidth < 1024) {
                        // Logika Mobile (Offcanvas Overlay)
                        sidebar.classList.remove('-translate-x-full');
                        mobileOverlay.classList.remove('hidden');
                        setTimeout(() => mobileOverlay.classList.replace('opacity-0', 'opacity-100'), 10);
                    } else {
                        // Logika Desktop (Collapse Kecil)
                        sidebar.classList.toggle('collapsed');
                    }
                });
            }

            // Close Mobile Sidebar
            function closeSidebar() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.replace('opacity-100', 'opacity-0');
                    setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
                }
            }

            if(closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
            if(mobileOverlay) mobileOverlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>