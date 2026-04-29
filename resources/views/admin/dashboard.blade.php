<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Satu Sanzaya</title>
    
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

    <!-- MENGAMBIL DATA STATISTIK DAN NOTIFIKASI LANGSUNG -->
    @php
        $totalUsers = \App\Models\User::count();
        $totalSppd = \App\Models\TravelRequest::count();
        $pendingSppd = \App\Models\TravelRequest::whereIn('status', ['pending_l1', 'pending_l2'])->count();
        $approvedSppd = \App\Models\TravelRequest::where('status', 'approved')->count();

        $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get();
        $recentSppd = \App\Models\TravelRequest::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        
        // Logika Data Notifikasi Admin
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
            
            <a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                <i class="fas fa-border-all w-5 text-center text-lg mr-3"></i>
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
                    <h1 class="text-xl font-bold text-slate-800">Beranda Administrator</h1>
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
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 no-scrollbar content-area">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-1">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] ?? 'Admin' }}!</h2>
                    <p class="text-slate-500 text-sm m-0">Berikut adalah ringkasan sistem Satu Sanzaya hari ini.</p>
                </div>
                <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm flex items-center gap-2 text-sm font-medium text-slate-600">
                    <i class="far fa-calendar-alt text-brand-500"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <!-- ROW 1: KARTU STATISTIK -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalUsers }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Total Pengguna</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalSppd }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Total SPPD</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $pendingSppd }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Proses Validasi</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $approvedSppd }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">SPPD Selesai</p>
                    </div>
                </div>
            </div>

            <!-- ROW 2: DAFTAR TERBARU -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                
                <!-- PENGGUNA TERBARU -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-soft h-full flex flex-col overflow-hidden list-card">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 list-card-title">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2 m-0 text-base">
                            <span class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center">
                                <i class="fas fa-user-plus text-sm"></i>
                            </span>
                            Pengguna Baru Ditambahkan
                        </h3>
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-800 transition-colors">Lihat Semua</a>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto no-scrollbar p-2 list-container">
                        @forelse($recentUsers as $u)
                            <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-colors duration-200 border border-transparent hover:border-slate-100 group list-item">
                                <div class="flex items-center gap-4 item-left">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-brand-600 flex items-center justify-center font-bold text-sm border border-slate-200 shadow-sm item-avatar">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm mb-0.5">{{ $u->name }}</p>
                                        <p class="text-xs font-medium text-slate-500">{{ $u->email }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2 text-end">
                                    @php
                                        $roleBadge = 'bg-slate-100 text-slate-600';
                                        if($u->role == 'admin') $roleBadge = 'bg-rose-50 text-rose-600 border border-rose-200/50';
                                        if($u->role == 'manager') $roleBadge = 'bg-emerald-50 text-emerald-600 border border-emerald-200/50';
                                        if($u->role == 'finance') $roleBadge = 'bg-purple-50 text-purple-600 border border-purple-200/50';
                                        if($u->role == 'staff') $roleBadge = 'bg-brand-50 text-brand-600 border border-brand-200/50';
                                    @endphp
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider shadow-sm {{ $roleBadge }}">
                                        {{ $u->role }}
                                    </span>
                                    <p class="m-0 text-slate-400 font-medium" style="font-size: 10px;">{{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center p-10 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-2xl mb-4">
                                    <i class="fas fa-users"></i>
                                </div>
                                <p class="text-sm text-slate-500 font-medium">Belum ada pengguna di sistem.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- SPPD TERBARU -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-soft h-full flex flex-col overflow-hidden list-card">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center bg-slate-50/50 list-card-title">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2 m-0 text-base">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </span>
                            Pengajuan SPPD Terbaru
                        </h3>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto no-scrollbar p-2 list-container">
                        @forelse($recentSppd as $sppd)
                            <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-colors duration-200 border border-transparent hover:border-slate-100 group list-item">
                                <div class="flex items-center gap-4 item-left">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center font-bold text-lg border border-emerald-100 shadow-sm item-avatar">
                                        <i class="fas fa-car-side"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm mb-0.5 truncate max-w-[150px] sm:max-w-[200px]">Tujuan: {{ $sppd->destination }}</p>
                                        <p class="text-xs font-medium text-slate-500 truncate max-w-[150px] sm:max-w-[200px]">Oleh: {{ $sppd->user->name ?? 'User Dihapus' }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2 text-end">
                                    @php
                                        $sppdBadge = 'bg-slate-100 text-slate-600';
                                        $sppdText = $sppd->status;
                                        if($sppd->status == 'pending_l1') { $sppdBadge = 'bg-amber-50 text-amber-600 border border-amber-200/50'; $sppdText = 'Cek Manajer'; }
                                        if($sppd->status == 'pending_l2') { $sppdBadge = 'bg-brand-50 text-brand-600 border border-brand-200/50'; $sppdText = 'Cek Finance'; }
                                        if($sppd->status == 'approved' || $sppd->status == 'selesai') { $sppdBadge = 'bg-emerald-50 text-emerald-600 border border-emerald-200/50'; $sppdText = 'Selesai'; }
                                        if($sppd->status == 'rejected') { $sppdBadge = 'bg-rose-50 text-rose-600 border border-rose-200/50'; $sppdText = 'Ditolak'; }
                                    @endphp
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm badge-status {{ $sppdBadge }}">
                                        {{ $sppdText }}
                                    </span>
                                    <p class="m-0 text-slate-400 font-medium" style="font-size: 10px;">{{ \Carbon\Carbon::parse($sppd->created_at)->format('d M, H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center p-10 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-2xl mb-4">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <p class="text-sm text-slate-500 font-medium">Belum ada riwayat pengajuan SPPD.</p>
                            </div>
                        @endforelse
                    </div>
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