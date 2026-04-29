<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Perubahan Sistem - Satu Sanzaya</title>
    
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

    <!-- MENGAMBIL DATA LOG AKTIVITAS (Jika Model ActivityLog Tersedia) -->
    @php
        $logs = collect();
        $notifications = collect();
        $hasNewNotif = false;
        
        // Cek apakah model ActivityLog ada di sistem, jika ada tarik datanya
        if(class_exists('\App\Models\ActivityLog')) {
            $logs = \App\Models\ActivityLog::with('user')->latest()->take(50)->get();
            // Data untuk notifikasi pop-up (ambil 5 teratas)
            $notifications = $logs->take(5);
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
            
            <a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                <i class="fas fa-clock-rotate-left w-5 text-center text-lg mr-3"></i>
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
                    <h1 class="text-xl font-bold text-slate-800">Riwayat Perubahan Sistem</h1>
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
            
            <!-- FILTER CARD -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft mb-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="col-span-1 md:col-span-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Filter Tanggal</label>
                        <div class="flex items-center gap-2">
                            <input type="date" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700">
                            <span class="text-slate-400 font-medium">-</span>
                            <input type="date" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700">
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Aktivitas</label>
                        <select class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white appearance-none">
                            <option value="">Semua Aktivitas</option>
                            <option value="create">Penambahan Data</option>
                            <option value="update">Perubahan Data</option>
                            <option value="delete">Penghapusan Data</option>
                            <option value="approve">Persetujuan SPPD</option>
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Keterangan / User</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" placeholder="Ketik kata kunci...">
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <button class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-sm text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                    </div>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-soft overflow-hidden flex flex-col">
                
                <div class="px-6 py-5 border-b border-slate-100 flex items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2 m-0 text-base">
                        <span class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center">
                            <i class="fas fa-clock-rotate-left text-sm"></i>
                        </span>
                        Log Aktivitas Pengguna (Audit Trail)
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="bg-white border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <th class="p-5 w-[15%]">Waktu</th>
                                <th class="p-5 w-[25%]">Pelaku (Aktor)</th>
                                <th class="p-5 w-[15%]">Aktivitas</th>
                                <th class="p-5 w-[45%]">Keterangan Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($logs as $log)
                                @php
                                    // Menentukan warna badge berdasarkan action
                                    $action = strtolower($log->action ?? 'default');
                                    
                                    $badgeClass = 'bg-slate-50 text-slate-600 border-slate-200'; // Default
                                    
                                    if(str_contains($action, 'create') || str_contains($action, 'tambah')) {
                                        $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                    } elseif(str_contains($action, 'update') || str_contains($action, 'edit')) {
                                        $badgeClass = 'bg-brand-50 text-brand-600 border-brand-200';
                                    } elseif(str_contains($action, 'delete') || str_contains($action, 'hapus')) {
                                        $badgeClass = 'bg-rose-50 text-rose-600 border-rose-200';
                                    } elseif(str_contains($action, 'approve') || str_contains($action, 'setuju')) {
                                        $badgeClass = 'bg-purple-50 text-purple-600 border-purple-200';
                                    } elseif(str_contains($action, 'login')) {
                                        $badgeClass = 'bg-amber-50 text-amber-600 border-amber-200';
                                    }
                                @endphp
                                <tr class="hover:bg-brand-50/50 transition-colors duration-200 group">
                                    <td class="p-5 align-middle">
                                        <p class="font-bold text-slate-800 text-sm mb-0.5 leading-tight">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}</p>
                                        <p class="text-xs font-medium text-slate-500">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }} WITA</p>
                                    </td>
                                    <td class="p-5 align-middle">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs border border-white shadow-sm flex-shrink-0 group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-sm mb-0.5 leading-tight">{{ $log->user->name ?? 'Sistem Otomatis' }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $log->user->role ?? 'System' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5 align-middle">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border shadow-sm {{ $badgeClass }}">
                                            {{ $log->action ?? 'Aktivitas' }}
                                        </span>
                                    </td>
                                    <td class="p-5 align-middle">
                                        <p class="m-0 text-slate-700 text-sm leading-relaxed">{{ $log->description ?? '-' }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-10 text-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 text-3xl mx-auto mb-4">
                                            <i class="fas fa-history"></i>
                                        </div>
                                        <h4 class="text-slate-700 font-bold mb-1 text-lg">Belum Ada Riwayat Perubahan</h4>
                                        <p class="text-sm text-slate-500 max-w-md mx-auto">Semua aktivitas pengguna seperti login, penambahan data, dan perubahan akan tercatat di sini.</p>
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