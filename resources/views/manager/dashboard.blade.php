<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajer - Satu Sanzaya</title>
    
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

    <!-- MENGAMBIL DATA STATISTIK DAN NOTIFIKASI MANAGER LANGSUNG -->
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        // Menghitung jumlah SPPD yang menunggu ACC Manajer
        $menungguAcc = \App\Models\TravelRequest::where('status', 'pending_l1')->count();
        
        // Menghitung SPPD yang sudah diproses oleh Manajer ini
        $disetujuiManager = \App\Models\TravelRequest::where('l1_approver_id', $userId)
                              ->whereIn('status', ['pending_l2', 'approved', 'selesai'])
                              ->count();
        $ditolakManager = \App\Models\TravelRequest::where('l1_approver_id', $userId)
                            ->where('status', 'rejected')
                            ->count();
                            
        // Total yang pernah dipegang
        $totalDiproses = $disetujuiManager + $ditolakManager;

        // Mengambil daftar terbaru yang butuh ACC
        $antreanTerbaru = \App\Models\TravelRequest::with('user')
                            ->where('status', 'pending_l1')
                            ->orderBy('created_at', 'asc') // Yang paling lama mengantre diutamakan
                            ->take(5)
                            ->get();
                            
        // Logika Notifikasi khusus Manajer (Melihat SPPD yang pending_l1)
        $notifications = \App\Models\TravelRequest::with('user')
            ->where('status', 'pending_l1')
            ->latest()
            ->take(5)
            ->get();
        $hasNewNotif = $notifications->count() > 0;
    @endphp

    <!-- MOBILE OVERLAY -->
    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar bg-white w-[280px] h-full border-r border-slate-200 flex flex-col transition-all-ease fixed lg:relative z-50 -translate-x-full lg:translate-x-0 shadow-2xl lg:shadow-none">
        
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-center border-b border-slate-100 px-6 logo-area overflow-hidden">
            <a href="{{ route('manager.dashboard') ?? '#' }}" class="flex items-center group">
                <!-- Mempertahankan Logo Asli -->
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img max-w-[140px] group-hover:scale-105 transition-all-ease">
            </a>
            <!-- Close button for mobile -->
            <button id="closeSidebarBtn" class="lg:hidden absolute right-4 text-slate-400 hover:text-slate-800">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto no-scrollbar py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Menu Utama</p>
            
            <a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                <i class="fas fa-border-all w-5 text-center text-lg mr-3"></i>
                <span class="menu-text">Dashboard</span>
            </a>
            
            <a href="{{ route('approvals.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-file-signature w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Persetujuan SPPD</span>
                @if($menungguAcc > 0)
                    <span class="ml-auto bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm badge-count">{{ $menungguAcc }}</span>
                @endif
            </a>
            
            <a href="{{ route('manager.history') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-history w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Riwayat Proses</span>
            </a>
            
            <a href="{{ route('arsip.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-archive w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Arsip UC</span>
            </a>

            <div class="pt-4 pb-2">
                <div class="border-t border-slate-100"></div>
            </div>
            
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>

            <a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-paper-plane w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Buat Pengajuan</span>
            </a>
            
            <a href="{{ route('manager.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Pengaturan Akun</span>
            </a>
        </div>

        <!-- User Footer Mini -->
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
                <!-- Mempertahankan ikon fa-bars (Sekarang aktif di Desktop & Mobile) -->
                <button id="openSidebarBtn" class="hamburger-btn text-slate-500 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100 transition-colors outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-slate-800">Beranda Validator <span class="text-brand-500">(L1)</span></h1>
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
                            @forelse($notifications as $notif)
                                <a href="{{ route('approvals.show', $notif->id) }}" class="flex items-start gap-4 p-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group notification-item">
                                    <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-100 transition-colors notification-icon">
                                        <i class="fas fa-file-signature"></i>
                                    </div>
                                    <div class="flex-1 min-w-0 notification-content">
                                        <p class="text-sm text-slate-700 leading-snug mb-1">UC dari <span class="font-bold text-slate-900">{{ $notif->user->name ?? 'Staff' }}</span> menunggu ACC Anda.</p>
                                        <p class="text-xs text-slate-400"><i class="far fa-clock mr-1"></i><span>{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span></p>
                                    </div>
                                </a>
                            @empty
                                <div class="p-8 text-center notification-item">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300 notification-icon">
                                        <i class="fas fa-check-circle text-2xl"></i>
                                    </div>
                                    <p class="text-sm text-slate-500 font-medium notification-content">Belum ada notifikasi baru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- USER PROFILE -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200 user-profile">
                    <div class="hidden sm:block text-right user-info">
                        <p class="text-sm font-bold text-slate-800 leading-tight user-name">{{ Auth::user()->name ?? 'Manajer' }}</p>
                        <p class="text-xs font-medium text-slate-500 capitalize user-role">{{ Auth::user()->role ?? 'Manager' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-600 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md border-2 border-white ring-2 ring-slate-100 user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE DASHBOARD AREA -->
        <div class="flex-1 overflow-y-auto p-6 lg:p-10 no-scrollbar content-area">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-1">Halo, {{ explode(' ', Auth::user()->name)[0] ?? 'Manajer' }}! 👋</h2>
                    <p class="text-slate-500 text-sm">Berikut adalah ringkasan operasional perjalanan dinas tim Anda hari ini.</p>
                </div>
                <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm flex items-center gap-2 text-sm font-medium text-slate-600">
                    <i class="far fa-calendar-alt text-brand-500"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <!-- PREMIUM STATS CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        @if($menungguAcc > 0)
                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-lg">Action Needed</span>
                        @endif
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $menungguAcc }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Menunggu ACC</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $disetujuiManager }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Telah Di-ACC</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $ditolakManager }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Ditolak</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group stat-card">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalDiproses }}</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-1">Total Diproses</p>
                    </div>
                </div>

            </div>

            <!-- LAYOUT SPLIT -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- ACTION BANNER (Left, 1 Col on XL) -->
                <div class="xl:col-span-1">
                    @if($menungguAcc > 0)
                        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-lg shadow-orange-500/30 h-full flex flex-col justify-center action-card">
                            <!-- Decor Element -->
                            <i class="fas fa-bolt absolute -right-4 -bottom-6 text-[120px] text-white opacity-10 -rotate-12"></i>
                            
                            <div class="relative z-10">
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4 inline-block">Prioritas Tinggi</span>
                                <h4 class="text-2xl font-bold mb-3 leading-tight">Ada {{ $menungguAcc }} Dokumen Tertunda!</h4>
                                <p class="text-amber-50 text-sm mb-8 leading-relaxed">Tim Anda membutuhkan persetujuan (ACC L1) agar dokumen SPPD bisa diteruskan ke proses pencairan dana oleh tim Finance.</p>
                                
                                <a href="{{ route('approvals.index') ?? '#' }}" class="inline-flex items-center justify-center gap-2 bg-white text-orange-600 font-bold px-6 py-3.5 rounded-xl hover:bg-orange-50 hover:scale-105 transition-all duration-300 shadow-md btn-light-custom">
                                    Tinjau Sekarang <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-lg shadow-teal-500/30 h-full flex flex-col justify-center action-card">
                            <!-- Decor Element -->
                            <i class="fas fa-check-circle absolute -right-6 -bottom-6 text-[120px] text-white opacity-10 -rotate-12"></i>
                            
                            <div class="relative z-10">
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4 inline-block">All Clear</span>
                                <h4 class="text-2xl font-bold mb-3 leading-tight">Semua Tuntas! 🎉</h4>
                                <p class="text-teal-50 text-sm mb-8 leading-relaxed">Kerja luar biasa! Tidak ada pengajuan SPPD dari tim yang menunggu persetujuan Anda saat ini. Meja kerja Anda bersih.</p>
                                
                                <a href="{{ route('manager.history') ?? '#' }}" class="inline-flex items-center justify-center gap-2 bg-white/20 border border-white/30 backdrop-blur-md text-white font-bold px-6 py-3.5 rounded-xl hover:bg-white/30 transition-all duration-300 btn-light-custom">
                                    Lihat Riwayat <i class="fas fa-history"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- LIST ANTRIAN (Right, 2 Cols on XL) -->
                <div class="xl:col-span-2 flex flex-col">
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-soft h-full flex flex-col overflow-hidden list-card">
                        
                        <!-- Header Box -->
                        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 list-card-title">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2 m-0">
                                <span class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center">
                                    <i class="fas fa-inbox text-sm"></i>
                                </span>
                                Antrean Masuk (Butuh ACC)
                            </h3>
                            <a href="{{ route('approvals.index') ?? '#' }}" class="text-sm font-semibold text-brand-600 hover:text-brand-800 transition-colors">Lihat Semua</a>
                        </div>

                        <!-- List Items -->
                        <div class="flex-1 overflow-y-auto no-scrollbar p-2 list-container">
                            @forelse($antreanTerbaru as $sppd)
                                <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-colors duration-200 border border-transparent hover:border-slate-100 group list-item">
                                    
                                    <div class="flex items-center gap-4 item-left">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm item-icon">
                                            {{ strtoupper(substr($sppd->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm mb-0.5">{{ $sppd->user->name ?? 'Nama Staff' }} <span class="font-normal text-slate-500 mx-1">•</span> <span class="text-brand-600">{{ $sppd->destination }}</span></p>
                                            <p class="text-xs font-medium text-slate-500 flex items-center gap-1.5 m-0">
                                                <i class="far fa-calendar-alt text-slate-400"></i>
                                                Brkt: {{ \Carbon\Carbon::parse($sppd->start_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end gap-2 text-end">
                                        <a href="{{ route('approvals.show', $sppd->id) }}" class="bg-white border border-slate-200 text-slate-700 hover:text-brand-600 hover:border-brand-300 hover:bg-brand-50 text-xs font-bold px-4 py-2 rounded-lg transition-all shadow-sm">
                                            Review
                                        </a>
                                        <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md badge-status">
                                            {{ \Carbon\Carbon::parse($sppd->created_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="h-full flex flex-col items-center justify-center p-10 text-center">
                                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-400 text-3xl mb-4">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <h4 class="text-slate-700 font-bold mb-1">Antrean Kosong</h4>
                                    <p class="text-sm text-slate-500 max-w-sm m-0">Anda telah menyelesaikan semua peninjauan dokumen SPPD hari ini.</p>
                                </div>
                            @endforelse
                        </div>

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

            // --- Toggle Sidebar Logic (Mobile & Desktop) ---
            const sidebar = document.getElementById('sidebar');
            const openSidebarBtn = document.getElementById('openSidebarBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');
            const mobileOverlay = document.getElementById('mobileOverlay');

            // Open/Collapse Handler
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

            // Close Mobile Sidebar
            function closeSidebar() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.replace('opacity-100', 'opacity-0');
                    setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
                }
            }

            closeSidebarBtn.addEventListener('click', closeSidebar);
            mobileOverlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>