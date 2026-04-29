<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan SPPD - Satu Sanzaya</title>
    
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

        /* Hide Number Spinners */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type="number"] { -moz-appearance: textfield; }
    </style>
</head>
<body class="bg-surface text-slate-800 font-sans antialiased overflow-hidden flex h-screen">

    @php
        $userRole = strtolower(trim(Auth::user()->role));
        $reqId = request()->route('id');
        $req = \App\Models\TravelRequest::with(['user'])->find($reqId);
        
        $canApprove = false;
        if($req) {
            $status = strtolower(trim($req->status));
            // Hanya Manajer dan Finance yang bisa memproses ACC sesuai statusnya
            if(in_array($userRole, ['manager', 'hrd', 'kepala marketing']) && $status == 'pending_l1') {
                $canApprove = true;
            } elseif($userRole == 'finance' && $status == 'pending_l2') {
                $canApprove = true;
            }
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
        } elseif ($userRole === 'staff') {
            $notifications = \App\Models\TravelRequest::where('user_id', Auth::id())
                ->orderBy('updated_at', 'desc')
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
                    <span class="menu-text">Pengaturan Akun</span>
                </a>

            @elseif(in_array($userRole, ['manager', 'hrd', 'kepala marketing']))
                <a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-border-all w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                <a href="{{ route('approvals.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                    <i class="fas fa-file-signature w-5 text-center text-lg mr-3"></i>
                    <span class="menu-text">Persetujuan SPPD</span>
                </a>
                <a href="{{ route('manager.history') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-history w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Riwayat Proses</span>
                </a>
                <a href="{{ route('arsip.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-archive w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
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
                <a href="{{ route('approvals.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                    <i class="fas fa-file-invoice-dollar w-5 text-center text-lg mr-3"></i>
                    <span class="menu-text">Antrean Pencairan</span>
                </a>
                <a href="{{ route('finance.history') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-history w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Riwayat Pencairan</span>
                </a>
                <a href="{{ route('arsip.index') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-archive w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Arsip UC</span>
                </a>
                <div class="pt-4 pb-2"><div class="border-t border-slate-100"></div></div>
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>
                <a href="{{ route('finance.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Pengaturan Akun</span>
                </a>
                
            @elseif($userRole == 'staff')
                <a href="{{ route('staff.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-border-all w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                <a href="{{ route('staff.riwayat') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                    <i class="fas fa-clock-rotate-left w-5 text-center text-lg mr-3"></i>
                    <span class="menu-text">Riwayat Pengajuan</span>
                </a>
                <a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-file-lines w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Pengajuan UC</span>
                </a>
                <div class="pt-4 pb-2"><div class="border-t border-slate-100"></div></div>
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>
                <a href="{{ route('staff.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                    <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="menu-text">Settings</span>
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
                    <h1 class="text-xl font-bold text-slate-800">Review Dokumen SPPD</h1>
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
                                
                            @elseif($userRole === 'staff')
                                @forelse($notifications as $notif)
                                    @php
                                        $notifIcon = 'fa-file-alt'; $notifClass = 'bg-brand-50 text-brand-500 group-hover:bg-brand-100'; $statusText = 'Sedang diproses';
                                        if($notif->status == 'pending_l1') { $notifClass = 'bg-amber-50 text-amber-500 group-hover:bg-amber-100'; $notifIcon = 'fa-hourglass-half'; $statusText = 'Menunggu ACC Manajer'; }
                                        if($notif->status == 'pending_l2') { $notifClass = 'bg-brand-50 text-brand-500 group-hover:bg-brand-100'; $notifIcon = 'fa-money-check'; $statusText = 'Menunggu Pencairan Finance'; }
                                        if($notif->status == 'approved') { $notifClass = 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-100'; $notifIcon = 'fa-check-circle'; $statusText = 'Disetujui & Dicairkan'; }
                                        if($notif->status == 'rejected') { $notifClass = 'bg-rose-50 text-rose-500 group-hover:bg-rose-100'; $notifIcon = 'fa-times-circle'; $statusText = 'Ditolak'; }
                                    @endphp
                                    <a href="{{ route('staff.riwayat') ?? '#' }}" class="flex items-start gap-4 p-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group notification-item">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-colors {{ $notifClass }} notification-icon">
                                            <i class="fas {{ $notifIcon }}"></i>
                                        </div>
                                        <div class="flex-1 min-w-0 notification-content">
                                            <p class="text-sm text-slate-700 leading-snug mb-1">Pengajuan ke <strong>{{ $notif->destination }}</strong>: <span style="font-weight: 600;">{{ $statusText }}</span></p>
                                            <p class="text-xs text-slate-400"><i class="far fa-clock mr-1"></i><span>Update: {{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</span></p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-8 text-center notification-item">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300 notification-icon">
                                            <i class="fas fa-check-circle text-2xl"></i>
                                        </div>
                                        <p class="text-sm text-slate-500 font-medium notification-content">Belum ada pembaruan status.</p>
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
                                        <p class="text-sm text-slate-500 font-medium notification-content">Tidak ada pengajuan baru yang menunggu tindakan.</p>
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
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 no-scrollbar content-area">
            
            <div class="max-w-7xl mx-auto">
                
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('manager.history') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand-600 transition-colors mb-6">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                @if(!$req)
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 p-6 rounded-2xl flex items-center gap-4 shadow-sm">
                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                        <div>
                            <strong class="block text-base mb-1">Tidak Ada Data!</strong>
                            <span class="text-sm">Dokumen tidak ditemukan atau terjadi kesalahan dalam memuat data.</span>
                        </div>
                    </div>
                @else

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- KOLOM KIRI: DATA PENGAJUAN -->
                    <div class="col-lg-1 lg:col-span-2">
                        
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-soft p-6 md:p-8 mb-8">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b border-slate-100 pb-5 gap-4">
                                <div>
                                    <h4 class="text-xl font-bold text-slate-800 mb-1">Pengajuan Perjalanan Dinas (UC)</h4>
                                    <p class="text-slate-500 text-sm m-0">Tgl Dibuat: {{ \Carbon\Carbon::parse($req->created_at)->format('d F Y, H:i') }} WITA</p>
                                </div>
                                
                                @php
                                    $badgeClass = 'bg-slate-100 text-slate-600 border-slate-200';
                                    $badgeIcon = 'fa-info-circle';
                                    if($req->status == 'pending_l1') { $badgeClass = 'bg-amber-50 text-amber-600 border-amber-200/60'; $badgeIcon = 'fa-hourglass-half'; }
                                    if($req->status == 'pending_l2') { $badgeClass = 'bg-indigo-50 text-indigo-600 border-indigo-200/60'; $badgeIcon = 'fa-money-check'; }
                                    if($req->status == 'approved' || $req->status == 'selesai') { $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-200/60'; $badgeIcon = 'fa-check-circle'; }
                                    if($req->status == 'rejected') { $badgeClass = 'bg-rose-50 text-rose-600 border-rose-200/60'; $badgeIcon = 'fa-times-circle'; }
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold border shadow-sm uppercase tracking-wider {{ $badgeClass }}">
                                    <i class="fas {{ $badgeIcon }}"></i> Status: {{ str_replace('_', ' ', $req->status) }}
                                </span>
                            </div>

                            <!-- 1. Identitas -->
                            <div class="mb-8">
                                <h6 class="text-sm font-bold text-brand-600 uppercase tracking-wider flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                                    <i class="fas fa-user text-lg"></i> 1. Identitas Pemohon
                                </h6>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Pegawai</p>
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800">
                                            {{ $req->user->name ?? 'User Dihapus' }}
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jabatan / Divisi</p>
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 capitalize">
                                            {{ $req->user->role ?? '-' }} {{ $req->user->division ? '/ ' . $req->user->division : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Rute & Jadwal -->
                            <div class="mb-8">
                                <h6 class="text-sm font-bold text-brand-600 uppercase tracking-wider flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                                    <i class="fas fa-map-marked-alt text-lg"></i> 2. Rute & Jadwal
                                </h6>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Rute Perjalanan</p>
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 flex items-center flex-wrap gap-2">
                                            {{ $req->departure }} <i class="fas fa-arrow-right text-slate-400 text-[10px]"></i> <span class="text-brand-600">{{ $req->destination }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Pelaksanaan</p>
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800">
                                            <i class="far fa-calendar-alt text-slate-400 mr-2"></i> {{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }} <span class="text-slate-400 mx-1">s.d</span> {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Tim & Operasional -->
                            <div class="mb-8">
                                <h6 class="text-sm font-bold text-brand-600 uppercase tracking-wider flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                                    <i class="fas fa-users text-lg"></i> 3. Tim & Operasional
                                </h6>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Transportasi Digunakan</p>
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 flex items-center gap-3">
                                            @if($req->transportation_type == 'Darat')
                                                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center"><i class="fas fa-car"></i></div>
                                                Darat 
                                                @if($req->vehicle_number)
                                                    <span class="bg-slate-200 text-slate-600 text-xs px-2 py-1 rounded-md ml-auto">{{ $req->vehicle_number }}</span>
                                                @endif
                                            @elseif($req->transportation_type == 'Udara')
                                                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center"><i class="fas fa-plane"></i></div>
                                                Udara
                                            @else
                                                <div class="w-8 h-8 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center"><i class="fas fa-ship"></i></div>
                                                Laut
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pendamping</p>
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 min-h-[58px] flex items-center">
                                            @if($req->companion_1 || $req->companion_2)
                                                <ul class="m-0 pl-4 space-y-1">
                                                    @if($req->companion_1) <li>{{ $req->companion_1 }}</li> @endif
                                                    @if($req->companion_2) <li>{{ $req->companion_2 }}</li> @endif
                                                </ul>
                                            @else
                                                <span class="text-slate-400 italic">Berangkat sendiri (Tidak ada)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Rincian Estimasi Biaya -->
                            <div class="mb-4">
                                <h6 class="text-sm font-bold text-brand-600 uppercase tracking-wider flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                                    <i class="fas fa-file-invoice-dollar text-lg"></i> 4. Rincian Estimasi Biaya
                                </h6>
                                
                                @if($userRole == 'finance' && $canApprove)
                                    <div class="bg-indigo-50 border border-indigo-200 text-indigo-700 px-4 py-3 rounded-xl flex items-start gap-3 text-sm mb-6 shadow-sm">
                                        <i class="fas fa-info-circle mt-0.5 text-lg"></i>
                                        <div>
                                            <strong>Mode Edit Finance Aktif:</strong> Nominal di bawah adalah estimasi awal dari sistem berdasarkan jumlah hari. Anda dapat menyesuaikannya sebelum menyetujui pencairan.
                                        </div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Uang Makan -->
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Uang Makan</p>
                                        @if($userRole == 'finance' && $canApprove)
                                            <div class="flex relative shadow-sm rounded-xl">
                                                <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 font-bold text-sm">Rp</span>
                                                <input type="number" name="biaya_makan" id="biaya_makan" form="approvalForm" class="flex-1 w-full min-w-0 px-3 py-3 rounded-r-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 outline-none text-sm bg-white text-slate-700 font-bold z-10" value="{{ $req->biaya_makan ?? 0 }}" oninput="calculateTotal()" required>
                                            </div>
                                        @else
                                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 text-center">
                                                Rp {{ number_format($req->biaya_makan ?? 0, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Penginapan -->
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Penginapan</p>
                                        @if($userRole == 'finance' && $canApprove)
                                            <div class="flex relative shadow-sm rounded-xl">
                                                <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 font-bold text-sm">Rp</span>
                                                <input type="number" name="biaya_penginapan" id="biaya_penginapan" form="approvalForm" class="flex-1 w-full min-w-0 px-3 py-3 rounded-r-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 outline-none text-sm bg-white text-slate-700 font-bold z-10" value="{{ $req->biaya_penginapan ?? 0 }}" oninput="calculateTotal()" required>
                                            </div>
                                        @else
                                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 text-center">
                                                Rp {{ number_format($req->biaya_penginapan ?? 0, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Bensin / Trans -->
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Bensin / Trans.</p>
                                        @if($userRole == 'finance' && $canApprove)
                                            <div class="flex relative shadow-sm rounded-xl">
                                                <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 font-bold text-sm">Rp</span>
                                                <input type="number" name="biaya_bensin" id="biaya_bensin" form="approvalForm" class="flex-1 w-full min-w-0 px-3 py-3 rounded-r-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 outline-none text-sm bg-white text-slate-700 font-bold z-10" value="{{ $req->biaya_bensin ?? 0 }}" oninput="calculateTotal()" required>
                                            </div>
                                        @else
                                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 text-center">
                                                Rp {{ number_format($req->biaya_bensin ?? 0, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Total Biaya -->
                                    <div>
                                        <p class="text-xs font-black text-brand-600 uppercase tracking-wider mb-2">Total Biaya</p>
                                        @if($userRole == 'finance' && $canApprove)
                                            <div class="flex relative shadow-sm rounded-xl">
                                                <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-brand-300 bg-brand-100 text-brand-700 font-black text-sm">Rp</span>
                                                <input type="number" name="total_biaya" id="total_biaya" form="approvalForm" class="flex-1 w-full min-w-0 px-3 py-3 rounded-r-xl border border-brand-200 bg-brand-50 text-brand-700 font-black outline-none text-sm cursor-not-allowed z-10" value="{{ $req->total_biaya ?? 0 }}" readonly>
                                            </div>
                                        @else
                                            <div class="bg-gradient-to-br from-brand-600 to-indigo-600 border border-brand-500 rounded-xl px-4 py-3 text-sm font-black text-white text-center shadow-md">
                                                Rp {{ number_format($req->total_biaya ?? 0, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Catatan -->
                            @if($req->l1_note || $req->l2_note)
                                <div class="mt-8 pt-6 border-t border-slate-100">
                                    <h6 class="font-bold text-slate-700 mb-4 flex items-center gap-2"><i class="fas fa-comments text-slate-400"></i> Riwayat Catatan Pimpinan:</h6>
                                    
                                    @if($req->l1_note)
                                    <div class="bg-amber-50 border-l-4 border-amber-500 rounded-r-xl p-4 mb-3 shadow-sm">
                                        <p class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-1">Manajer (L1)</p>
                                        <p class="text-sm text-amber-900 m-0 italic">"{{ $req->l1_note }}"</p>
                                    </div>
                                    @endif
                                    
                                    @if($req->l2_note)
                                    <div class="bg-brand-50 border-l-4 border-brand-500 rounded-r-xl p-4 shadow-sm">
                                        <p class="text-xs font-bold text-brand-800 uppercase tracking-wider mb-1">Finance (L2)</p>
                                        <p class="text-sm text-brand-900 m-0 italic">"{{ $req->l2_note }}"</p>
                                    </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- KOLOM KANAN: PANEL AKSI -->
                    <div class="col-lg-1 xl:col-span-1 relative">
                        <!-- Sticky Wrapper -->
                        <div class="sticky top-[110px]">
                            <div class="bg-white rounded-3xl border border-slate-200 shadow-soft p-6 md:p-8">
                                
                                @if($canApprove)
                                    <!-- MODE TINDAKAN (Bisa ACC / Tolak) -->
                                    <div class="mb-6 border-b border-slate-100 pb-4">
                                        <h5 class="text-lg font-bold text-slate-800 mb-1">Tindakan Persetujuan</h5>
                                        <p class="text-slate-500 text-xs leading-relaxed">Silakan periksa dokumen dengan cermat. Berikan catatan opsional dan tentukan keputusan Anda.</p>
                                    </div>

                                    <form action="{{ route('approvals.process', $req->id) }}" method="POST" id="approvalForm">
                                        @csrf
                                        <input type="hidden" name="action" id="approvalAction" value="">
                                        
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Tambahan (Opsional)</label>
                                        <textarea name="note" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 resize-none h-28 mb-6" placeholder="Tulis instruksi atau alasan penolakan di sini..."></textarea>
                                        
                                        <div class="flex flex-col gap-3">
                                            <button type="button" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 text-sm" onclick="confirmAction('approve')">
                                                <i class="fas fa-check-circle text-lg"></i> 
                                                @if($userRole == 'finance') Transfer & Cairkan Dana @else Setujui Pengajuan (ACC) @endif
                                            </button>
                                            
                                            <button type="button" class="w-full inline-flex items-center justify-center gap-2 bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 hover:text-rose-700 font-bold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5 text-sm" onclick="confirmAction('reject')">
                                                <i class="fas fa-times-circle text-lg"></i> Tolak Pengajuan
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <!-- MODE BACA SAJA (Read Only) -->
                                    <div class="mb-6 border-b border-slate-100 pb-4">
                                        <h5 class="text-lg font-bold text-slate-800 mb-1">Status Dokumen</h5>
                                        <p class="text-slate-500 text-xs leading-relaxed">Anda tidak dapat mengubah status dokumen ini karena telah diproses atau di luar wewenang Anda.</p>
                                    </div>
                                    
                                    @php
                                        $alertBg = 'bg-brand-50 text-brand-600 border-brand-200';
                                        $alertIcon = 'fa-hourglass-half';
                                        $alertTitle = str_replace('_', ' ', $req->status);
                                        
                                        if($req->status == 'approved' || $req->status == 'selesai') { 
                                            $alertBg = 'bg-emerald-50 text-emerald-600 border-emerald-200'; 
                                            $alertIcon = 'fa-check-circle';
                                            $alertTitle = 'Telah Disetujui';
                                        } elseif($req->status == 'rejected') { 
                                            $alertBg = 'bg-rose-50 text-rose-600 border-rose-200'; 
                                            $alertIcon = 'fa-times-circle';
                                            $alertTitle = 'Telah Ditolak';
                                        }
                                    @endphp
                                    
                                    <div class="text-center p-6 border rounded-2xl shadow-sm {{ $alertBg }} mb-6">
                                        <i class="fas {{ $alertIcon }} text-4xl mb-3"></i>
                                        <h6 class="font-bold text-base uppercase tracking-wide">{{ $alertTitle }}</h6>
                                    </div>
                                    
                                    <!-- Tombol Cetak PDF -->
                                    @if($req->status == 'approved' || $req->status == 'selesai')
                                        <a href="{{ route('pengajuan.cetak', $req->id) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 text-sm">
                                            <i class="fas fa-file-pdf"></i> Unduh PDF Dokumen
                                        </a>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                @endif

            </div>
        </div>
    </main>

    <!-- INTERACTIVE SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        sidebar.classList.remove('-translate-x-full');
                        mobileOverlay.classList.remove('hidden');
                        setTimeout(() => mobileOverlay.classList.replace('opacity-0', 'opacity-100'), 10);
                    } else {
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

        // --- LOGIKA MENGHITUNG TOTAL BIAYA SECARA REAL-TIME (KHUSUS FINANCE EDIT MODE) ---
        function calculateTotal() {
            let makanInput = document.getElementById('biaya_makan');
            let penginapanInput = document.getElementById('biaya_penginapan');
            let bensinInput = document.getElementById('biaya_bensin');
            
            if(makanInput && penginapanInput && bensinInput) {
                let makan = parseFloat(makanInput.value) || 0;
                let penginapan = parseFloat(penginapanInput.value) || 0;
                let bensin = parseFloat(bensinInput.value) || 0;
                
                let total = makan + penginapan + bensin;
                document.getElementById('total_biaya').value = total;
            }
        }

        // --- KONFIRMASI TINDAKAN DENGAN SWEETALERT ---
        function confirmAction(actionType) {
            const isApprove = actionType === 'approve';
            const actionText = isApprove ? 'Menyetujui' : 'Menolak';
            const btnColor = isApprove ? '#10B981' : '#DC2626';

            Swal.fire({
                title: 'Konfirmasi ' + actionText,
                text: "Apakah Anda yakin ingin " + actionText.toLowerCase() + " pengajuan ini?",
                icon: isApprove ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonColor: btnColor,
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'Ya, ' + actionText + '!',
                cancelButtonText: '<span class="text-slate-600 font-medium">Batal</span>',
                customClass: {
                    popup: 'rounded-3xl p-4',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold border border-slate-200 hover:bg-slate-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set nilai hidden input action
                    document.getElementById('approvalAction').value = actionType;
                    
                    // Tampilkan loading & submit form
                    Swal.fire({
                        title: 'Memproses Dokumen...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        customClass: { popup: 'rounded-3xl p-4' }
                    });
                    
                    document.getElementById('approvalForm').submit();
                }
            });
        }
    </script>
</body>
</html>