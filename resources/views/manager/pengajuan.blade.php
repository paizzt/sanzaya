<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Pengajuan UC - Satu Sanzaya</title>
    
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

        /* Custom Radio Button Style */
        .custom-radio { accent-color: #2563eb; width: 1.2rem; height: 1.2rem; cursor: pointer; }
    </style>
</head>
<body class="bg-surface text-slate-800 font-sans antialiased overflow-hidden flex h-screen">

    <!-- MENGAMBIL DATA NOTIFIKASI MANAGER -->
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        $menungguAcc = \App\Models\TravelRequest::where('status', 'pending_l1')->count();

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
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img max-w-[140px] group-hover:scale-105 transition-all-ease">
            </a>
            <button id="closeSidebarBtn" class="lg:hidden absolute right-4 text-slate-400 hover:text-slate-800">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto no-scrollbar py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Menu Utama</p>
            
            <a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-border-all w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
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

            <a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl bg-brand-50 text-brand-600 font-medium transition-all-ease">
                <i class="fas fa-paper-plane w-5 text-center text-lg mr-3"></i>
                <span class="menu-text">Buat Pengajuan</span>
            </a>
            
            <a href="{{ route('manager.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
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
                    <h1 class="text-xl font-bold text-slate-800">Pengajuan UC Baru</h1>
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

        <!-- SCROLLABLE CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 no-scrollbar content-area">
            
            <div class="max-w-5xl mx-auto">
                
                <div class="bg-white rounded-3xl border border-slate-200 shadow-soft p-6 md:p-10">
                    
                    <div class="mb-8 border-b border-slate-100 pb-6">
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Form Pengajuan Biaya (UC)</h2>
                        <p class="text-slate-500 text-sm">Lengkapi formulir di bawah ini untuk mengajukan biaya perjalanan dinas Upcountry.</p>
                    </div>

                    <!-- Alert Error Validasi -->
                    @if($errors->any())
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl shadow-sm">
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

                    <form action="{{ route('manager.pengajuan.store') }}" method="POST" id="pengajuanForm">
                        @csrf
                        <input type="hidden" name="direct_to_finance" value="1">
                        
                        <!-- FITUR KHUSUS MANAJER: BISA MEWAKILKAN STAFF -->
                        <div class="mb-10 bg-gradient-to-br from-brand-50 to-indigo-50 border border-brand-100 rounded-2xl p-6 shadow-sm">
                            <label class="flex items-center gap-2 text-sm font-bold text-brand-700 uppercase tracking-wider mb-3">
                                <i class="fas fa-user-tie text-lg"></i> Buatkan UC Untuk Staf (Opsional)
                            </label>
                            <select name="for_user_id" class="w-full px-4 py-3 rounded-xl border border-brand-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-white text-slate-700 shadow-sm appearance-none">
                                <option value="">-- Kosongkan Jika Pengajuan Untuk Diri Sendiri --</option>
                                @foreach($staffList as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->division ?? 'Staff' }})</option>
                                @endforeach
                            </select>
                            <div class="mt-3 flex items-start gap-2 text-brand-600/80 text-xs font-medium">
                                <i class="fas fa-info-circle mt-0.5"></i>
                                <p>Pilih nama staf jika Anda mewakilkan pembuatan UC ini. Pengajuan akan mem-bypass ACC L1 Anda dan langsung masuk ke antrean pencairan tim Finance.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Identitas (View Only) -->
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">1. Nama Pembuat Form</label>
                                <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 font-medium outline-none cursor-not-allowed" value="{{ Auth::user()->name ?? '' }}" readonly>
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">2. Jabatan Anda</label>
                                <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 font-medium outline-none cursor-not-allowed" value="{{ ucfirst(Auth::user()->role ?? '') }} {{ Auth::user()->division ?? '' }}" readonly>
                            </div>

                            <div class="col-span-1 md:col-span-2 my-2"><hr class="border-slate-100"></div>

                            <!-- Rute Perjalanan -->
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">3. Kota Keberangkatan <span class="text-rose-500">*</span></label>
                                <input type="text" name="departure" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 placeholder-slate-400" placeholder="Contoh: Makassar..." required>
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">4. Kota Tujuan <span class="text-rose-500">*</span></label>
                                <input type="text" name="destination" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 placeholder-slate-400" placeholder="Contoh: Pinrang, Parepare..." required>
                            </div>

                            <!-- Tanggal -->
                            <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">5. Berangkat <span class="text-rose-500">*</span></label>
                                    <input type="date" name="start_date" id="start_date" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" required onchange="calculateDays()">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">6. Pulang <span class="text-rose-500">*</span></label>
                                    <input type="date" name="end_date" id="end_date" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700" required onchange="calculateDays()">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">7. Waktu</label>
                                    <input type="text" id="waktu_hari" class="w-full px-4 py-3 rounded-xl border border-brand-200 bg-brand-50 text-brand-700 font-bold outline-none cursor-not-allowed" placeholder="0 Hari" readonly>
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2 my-2"><hr class="border-slate-100"></div>

                            <!-- Pendamping -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">8. Pendamping Perjalanan (Opsional)</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <select name="companion_1" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 appearance-none">
                                        <option value="">-- Pendamping 1 --</option>
                                        @foreach($usersList as $u)
                                            <option value="{{ $u->name }} - {{ ucfirst($u->role) }} {{ $u->division }}">{{ $u->name }} ({{ ucfirst($u->role) }} {{ $u->division }})</option>
                                        @endforeach
                                    </select>
                                    <select name="companion_2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 appearance-none">
                                        <option value="">-- Pendamping 2 --</option>
                                        @foreach($usersList as $u)
                                            <option value="{{ $u->name }} - {{ ucfirst($u->role) }} {{ $u->division }}">{{ $u->name }} ({{ ucfirst($u->role) }} {{ $u->division }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Transportasi -->
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">9. Jenis Transportasi <span class="text-rose-500">*</span></label>
                                <div class="flex flex-wrap gap-6 bg-slate-50 px-4 py-3 rounded-xl border border-slate-200">
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-slate-700">
                                        <input type="radio" name="transportation_type" value="Darat" class="custom-radio" required checked> Darat
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-slate-700">
                                        <input type="radio" name="transportation_type" value="Laut" class="custom-radio"> Laut
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-slate-700">
                                        <input type="radio" name="transportation_type" value="Udara" class="custom-radio"> Udara
                                    </label>
                                </div>
                            </div>

                            <!-- No Polisi -->
                            <div class="col-span-1" id="no_polisi_div">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">10. No. Polisi Kendaraan</label>
                                <input type="text" name="vehicle_number" id="vehicle_number" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 placeholder-slate-400" placeholder="Contoh: DD 1234 XY">
                            </div>
                            
                            <!-- Estimasi Bensin -->
                            <div class="col-span-1 md:col-span-2 mt-2">
                                <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2"><i class="fas fa-gas-pump me-1"></i> Estimasi Biaya Bensin (Manual)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">Rp</span>
                                    <input type="number" name="biaya_bensin" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring focus:ring-brand-500/20 transition-all outline-none text-sm bg-slate-50 focus:bg-white text-slate-700 placeholder-slate-400" placeholder="Contoh: 150000 (Jika ada)">
                                </div>
                                <p class="text-xs text-slate-400 mt-2 italic">*Biaya makan dan penginapan harian (Lumpsum) akan dihitung otomatis oleh sistem.</p>
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-slate-100">
                            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-base py-4 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2" id="btnSubmit">
                                <i class="fas fa-paper-plane"></i> Ajukan Permohonan UC
                            </button>
                        </div>

                    </form>
                </div>
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
                        if(badgeDot) badgeDot.style.display = 'none';
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

            // --- HIDE/SHOW NOMOR POLISI ---
            document.querySelectorAll('input[name="transportation_type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const noPolisiDiv = document.getElementById('no_polisi_div');
                    const noPolisiInput = document.getElementById('vehicle_number');
                    if(this.value === 'Darat') {
                        noPolisiDiv.style.display = 'block';
                    } else {
                        noPolisiDiv.style.display = 'none';
                        noPolisiInput.value = ''; 
                    }
                });
            });

            // --- FORM SUBMIT LOADING ---
            document.getElementById('pengajuanForm').addEventListener('submit', function(e) {
                const btn = document.getElementById('btnSubmit');
                if(btn.classList.contains('cursor-not-allowed')) {
                    e.preventDefault();
                    return;
                }
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sedang Memproses...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                btn.classList.remove('hover:-translate-y-0.5', 'hover:shadow-xl');
            });
        });

        // --- KALKULATOR HARI OTOMATIS ---
        function calculateDays() {
            const startInput = document.getElementById('start_date').value;
            const endInput = document.getElementById('end_date').value;
            const hariInput = document.getElementById('waktu_hari');

            if (startInput && endInput) {
                const startDate = new Date(startInput);
                const endDate = new Date(endInput);

                if (endDate < startDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Tidak Valid',
                        text: 'Tanggal pulang tidak boleh mendahului tanggal keberangkatan!',
                        confirmButtonColor: '#3b82f6'
                    });
                    document.getElementById('end_date').value = '';
                    hariInput.value = '';
                    return;
                }

                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
                
                hariInput.value = diffDays + ' Hari';
            }
        }
    </script>
</body>
</html>