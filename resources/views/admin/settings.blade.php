<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Akun Admin - Satu Sanzaya</title>
    
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

            <a href="{{ route('admin.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                <i class="fas fa-gear w-5 text-center text-lg mr-3"></i>
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
                    <h1 class="text-xl font-bold text-slate-800">Pengaturan Akun & Sistem</h1>
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
            
            <div class="max-w-6xl mx-auto">

                <!-- Alert jika ada pesan sukses dari backend -->
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl flex justify-between items-center shadow-sm">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-xl"></i>
                            <span class="font-semibold text-sm">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="text-emerald-500 hover:text-emerald-800 focus:outline-none" onclick="this.parentElement.remove();">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                @endif
                
                <!-- Alert Error Validasi -->
                @if($errors->any())
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-2 mb-2 font-bold">
                            <i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan:
                        </div>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    
                    <!-- BAGIAN 1: PROFIL PRIBADI -->
                    <div class="xl:col-span-2">
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-soft p-6 sm:p-8 h-full">
                            <div class="flex items-center gap-3 mb-8 border-b border-slate-100 pb-4">
                                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-slate-800">Informasi Profil Administrator</h2>
                                    <p class="text-slate-500 text-xs mt-0.5">Kelola identitas dan detail kontak akun Admin Anda.</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-8">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-brand-50 to-indigo-50 text-brand-600 flex items-center justify-center font-bold text-4xl shadow-sm border-4 border-white ring-1 ring-slate-200">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="text-center sm:text-left pt-2">
                                    <h5 class="text-lg font-bold text-slate-800 mb-1">{{ Auth::user()->name ?? 'Administrator' }}</h5>
                                    <p class="text-slate-500 text-sm mb-3">{{ Auth::user()->email ?? 'admin@sanzaya.com' }}</p>
                                    <button class="bg-white border border-slate-200 text-slate-600 hover:text-brand-600 hover:border-brand-300 hover:bg-brand-50 text-xs font-bold px-4 py-2 rounded-lg transition-all shadow-sm">
                                        <i class="fas fa-camera me-1"></i> Ubah Foto Profil
                                    </button>
                                </div>
                            </div>

                            <form id="profileForm" action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                        <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" value="{{ Auth::user()->name ?? '' }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Akun</label>
                                        <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" value="{{ Auth::user()->email ?? '' }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Handphone</label>
                                        <input type="text" name="phone" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" value="{{ Auth::user()->phone ?? '' }}" placeholder="08xxx">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jabatan (Sistem)</label>
                                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 font-medium outline-none cursor-not-allowed uppercase" value="{{ Auth::user()->role ?? 'ADMIN' }}" disabled>
                                        <p class="text-[10px] text-slate-400 mt-2 italic">Hak akses super-admin tidak dapat diubah di sini.</p>
                                    </div>
                                </div>

                                <div class="mt-8 pt-6 border-t border-slate-100 text-right">
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 text-sm">
                                        <i class="fas fa-save"></i> Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- BAGIAN 2: KEAMANAN & PASSWORD -->
                    <div class="xl:col-span-1">
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-soft p-6 sm:p-8 h-full">
                            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-slate-800">Keamanan</h2>
                                    <p class="text-slate-500 text-xs mt-0.5">Ubah kata sandi super-admin.</p>
                                </div>
                            </div>
                            
                            <p class="text-slate-500 text-xs mb-6 leading-relaxed">Penting! Pastikan Anda menggunakan kata sandi yang sangat kuat untuk melindungi akses data krusial perusahaan.</p>

                            <form id="passwordForm" action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                                    <div class="relative">
                                        <input type="password" name="current_password" id="current_password" class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" required>
                                        <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-slate-400 hover:text-brand-500 focus:outline-none transition-colors">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Baru</label>
                                    <div class="relative">
                                        <input type="password" name="new_password" id="new_password" class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" required>
                                        <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-slate-400 hover:text-brand-500 focus:outline-none transition-colors">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" required>
                                </div>

                                <!-- Field tersembunyi agar form validasi ProfileController lewat tanpa nama/email karena ini form terpisah -->
                                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 text-sm">
                                    <i class="fas fa-key"></i> Perbarui Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

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

        // --- FUNGSI LIHAT/SEMBUNYIKAN PASSWORD ---
        function togglePassword(inputId, btnElement) {
            const input = document.getElementById(inputId);
            const icon = btnElement.querySelector('i');
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>