<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan UC - Satu Sanzaya</title>
    
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
            .sidebar.collapsed .btn-create span { display: none; }
        }
    </style>
</head>
<body class="bg-surface text-slate-800 font-sans antialiased overflow-hidden flex h-screen">

    <!-- MENGAMBIL DATA NOTIFIKASI PRIBADI STAFF -->
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        // Logika Notifikasi khusus Staff
        $notifications = \App\Models\TravelRequest::where('user_id', $userId)
                            ->orderBy('updated_at', 'desc')
                            ->take(5)
                            ->get();
        $hasNewNotif = $notifications->count() > 0;
    @endphp

    <!-- MOBILE OVERLAY -->
    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden"></div>

    <!-- SIDEBAR STAFF -->
    <aside id="sidebar" class="sidebar bg-white w-[280px] h-full border-r border-slate-200 flex flex-col transition-all-ease fixed lg:relative z-50 -translate-x-full lg:translate-x-0 shadow-2xl lg:shadow-none">
        
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-center border-b border-slate-100 px-6 logo-area overflow-hidden">
            <a href="{{ route('staff.dashboard') ?? '#' }}" class="flex items-center group">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img max-w-[140px] group-hover:scale-105 transition-all-ease">
            </a>
            <button id="closeSidebarBtn" class="lg:hidden absolute right-4 text-slate-400 hover:text-slate-800">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto no-scrollbar py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Menu Utama</p>
            
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

            <div class="pt-4 pb-2">
                <div class="border-t border-slate-100"></div>
            </div>
            
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 sidebar-title">Pribadi</p>
            
            <a href="{{ route('staff.settings') ?? '#' }}" class="menu-item flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all-ease group">
                <i class="fas fa-gear w-5 text-center text-lg mr-3 group-hover:text-brand-500 transition-colors"></i>
                <span class="menu-text">Pengaturan Akun</span>
            </a>
        </div>

        <div class="p-4 border-t border-slate-100">
            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">@csrf</form>
            <button onclick="document.getElementById('logout-form').submit();" class="menu-item flex items-center px-4 py-3 w-full rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600 font-medium transition-all-ease group mb-3">
                <i class="fas fa-sign-out-alt w-5 text-center text-lg mr-3 group-hover:-translate-x-1 transition-transform"></i>
                <span class="menu-text">Keluar Sistem</span>
            </button>
            
            <a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="btn-create flex items-center justify-center gap-2 w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-4 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                <i class="fas fa-plus"></i> <span class="menu-text">Buat Pengajuan</span>
            </a>
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
                    <h1 class="text-xl font-bold text-slate-800">Detail Pengajuan Saya</h1>
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
                            <h3 class="font-semibold text-slate-800">Notifikasi Status</h3>
                            @if($hasNewNotif)
                                <span class="text-xs bg-brand-100 text-brand-700 font-bold px-2 py-1 rounded-md">{{ $notifications->count() }} Update</span>
                            @endif
                        </div>
                        <div class="max-h-[320px] overflow-y-auto no-scrollbar notification-list">
                            @forelse($notifications as $notif)
                                @php
                                    $notifClass = 'bg-brand-50 text-brand-500 group-hover:bg-brand-100'; $notifIcon = 'fa-file-alt'; $statusText = 'Sedang diproses';
                                    if($notif->status == 'pending_l1') { $notifClass = 'bg-amber-50 text-amber-500 group-hover:bg-amber-100'; $notifIcon = 'fa-hourglass-half'; $statusText = 'Menunggu ACC Manajer'; }
                                    if($notif->status == 'pending_l2') { $notifClass = 'bg-brand-50 text-brand-500 group-hover:bg-brand-100'; $notifIcon = 'fa-money-check'; $statusText = 'Menunggu Pencairan Finance'; }
                                    if($notif->status == 'approved') { $notifClass = 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-100'; $notifIcon = 'fa-check-circle'; $statusText = 'Disetujui & Dicairkan'; }
                                    if($notif->status == 'selesai') { $notifClass = 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-100'; $notifIcon = 'fa-check-double'; $statusText = 'Tuntas (Ada Result)'; }
                                    if($notif->status == 'rejected') { $notifClass = 'bg-rose-50 text-rose-500 group-hover:bg-rose-100'; $notifIcon = 'fa-times-circle'; $statusText = 'Ditolak'; }
                                @endphp
                                <a href="{{ route('staff.pengajuan.track', $notif->id) }}" class="flex items-start gap-4 p-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group notification-item">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-colors {{ $notifClass }} notification-icon">
                                        <i class="fas {{ $notifIcon }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0 notification-content">
                                        <p class="text-sm text-slate-700 leading-snug mb-1">Pengajuan ke <strong>{{ $notif->destination }}</strong>: <br><span class="font-bold">{{ $statusText }}</span></p>
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
                        </div>
                    </div>
                </div>

                <!-- USER PROFILE -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200 user-profile">
                    <div class="hidden sm:block text-right user-info">
                        <p class="text-sm font-bold text-slate-800 leading-tight user-name">{{ Auth::user()->name ?? 'Nama Staff' }}</p>
                        <p class="text-xs font-medium text-slate-500 capitalize user-role">{{ Auth::user()->role ?? 'staff' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-600 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md border-2 border-white ring-2 ring-slate-100 user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 no-scrollbar content-area">
            
            <div class="max-w-4xl mx-auto">
                
                <a href="{{ route('staff.riwayat') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand-600 transition-colors mb-6">
                    <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                </a>

                @if(!$pengajuan)
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 p-6 rounded-2xl flex items-center gap-4 shadow-sm">
                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                        <div>
                            <strong class="block text-base mb-1">Tidak Ada Data!</strong>
                            <span class="text-sm">Dokumen tidak ditemukan atau Anda tidak memiliki hak akses ke dokumen ini.</span>
                        </div>
                    </div>
                @else

                <!-- STATUS TRACKER CARD -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-soft p-6 md:p-8 mb-8">
                    <h5 class="font-bold text-slate-800 mb-8 text-center text-lg">Lacak Status Pengajuan</h5>
                    
                    <div class="relative flex justify-between items-center w-full max-w-2xl mx-auto mt-4 mb-6">
                        <!-- Connecting Line -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-100 -z-10 rounded-full"></div>
                        
                        <!-- Step 1: Dibuat -->
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg border-4 border-white transition-all duration-300 bg-emerald-500 text-white shadow-md">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 mt-3 text-center">Dikirim</span>
                        </div>
                        
                        <!-- Step 2: Manajer (L1) -->
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            @php
                                $step2Class = 'bg-slate-200 text-slate-500';
                                $step2Text = 'text-slate-400';
                                $step2Icon = '2';
                                
                                if(in_array($pengajuan->status, ['pending_l2', 'approved', 'selesai'])) {
                                    $step2Class = 'bg-emerald-500 text-white shadow-md';
                                    $step2Text = 'text-emerald-600';
                                    $step2Icon = '<i class="fas fa-check"></i>';
                                } elseif($pengajuan->status === 'pending_l1') {
                                    $step2Class = 'bg-brand-600 text-white ring-4 ring-brand-100 shadow-md';
                                    $step2Text = 'text-brand-600';
                                } elseif($pengajuan->status === 'rejected' && $pengajuan->l1_approver_id != null && $pengajuan->l2_approver_id == null) {
                                    // Ditolak di L1
                                    $step2Class = 'bg-rose-500 text-white ring-4 ring-rose-100 shadow-md';
                                    $step2Text = 'text-rose-600';
                                    $step2Icon = '<i class="fas fa-times"></i>';
                                } elseif($pengajuan->status === 'rejected' && $pengajuan->l1_approver_id == null) {
                                    $step2Class = 'bg-rose-500 text-white ring-4 ring-rose-100 shadow-md';
                                    $step2Text = 'text-rose-600';
                                    $step2Icon = '<i class="fas fa-times"></i>';
                                }
                            @endphp
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg border-4 border-white transition-all duration-300 {{ $step2Class }}">
                                {!! $step2Icon !!}
                            </div>
                            <span class="text-xs font-bold mt-3 text-center {{ $step2Text }}">Manajer (L1)</span>
                        </div>

                        <!-- Step 3: Finance (L2) -->
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            @php
                                $step3Class = 'bg-slate-200 text-slate-500';
                                $step3Text = 'text-slate-400';
                                $step3Icon = '3';
                                
                                if(in_array($pengajuan->status, ['approved', 'selesai'])) {
                                    $step3Class = 'bg-emerald-500 text-white shadow-md';
                                    $step3Text = 'text-emerald-600';
                                    $step3Icon = '<i class="fas fa-check"></i>';
                                } elseif($pengajuan->status === 'pending_l2') {
                                    $step3Class = 'bg-brand-600 text-white ring-4 ring-brand-100 shadow-md';
                                    $step3Text = 'text-brand-600';
                                } elseif($pengajuan->status === 'rejected' && $pengajuan->l2_approver_id != null) {
                                    // Ditolak di L2
                                    $step3Class = 'bg-rose-500 text-white ring-4 ring-rose-100 shadow-md';
                                    $step3Text = 'text-rose-600';
                                    $step3Icon = '<i class="fas fa-times"></i>';
                                }
                            @endphp
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg border-4 border-white transition-all duration-300 {{ $step3Class }}">
                                {!! $step3Icon !!}
                            </div>
                            <span class="text-xs font-bold mt-3 text-center {{ $step3Text }}">Finance (L2)</span>
                        </div>

                        <!-- Step 4: Selesai -->
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            @php
                                $step4Class = 'bg-slate-200 text-slate-500';
                                $step4Text = 'text-slate-400';
                                $step4Icon = '4';
                                
                                if($pengajuan->status === 'selesai') {
                                    $step4Class = 'bg-emerald-500 text-white shadow-md';
                                    $step4Text = 'text-emerald-600';
                                    $step4Icon = '<i class="fas fa-flag-checkered"></i>';
                                } elseif($pengajuan->status === 'approved') {
                                    $step4Class = 'bg-brand-600 text-white ring-4 ring-brand-100 shadow-md';
                                    $step4Text = 'text-brand-600';
                                }
                            @endphp
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg border-4 border-white transition-all duration-300 {{ $step4Class }}">
                                {!! $step4Icon !!}
                            </div>
                            <span class="text-xs font-bold mt-3 text-center {{ $step4Text }}">Selesai</span>
                        </div>
                    </div>

                    <!-- Alerts Info Status & Aksi Staff -->
                    @if($pengajuan->status === 'rejected')
                        <div class="mt-8 bg-rose-50 border border-rose-200 rounded-2xl p-5 shadow-sm">
                            <h6 class="font-bold text-rose-700 mb-1 flex items-center gap-2"><i class="fas fa-times-circle"></i> Pengajuan Ditolak</h6>
                            <p class="text-sm text-rose-600 m-0">Alasan Penolakan: "{{ $pengajuan->l2_note ?? $pengajuan->l1_note ?? 'Tidak ada catatan spesifik.' }}"</p>
                        </div>
                    @elseif($pengajuan->status === 'approved')
                        <div class="mt-8 bg-emerald-50 border border-emerald-200 rounded-2xl p-5 shadow-sm">
                            <h6 class="font-bold text-emerald-700 mb-1 flex items-center gap-2"><i class="fas fa-check-circle"></i> Dana Berhasil Dicairkan!</h6>
                            <p class="text-sm text-emerald-600 mb-4">Pengajuan Anda telah disetujui dan dana telah dicairkan. Harap segera melaksanakan perjalanan dinas dan **mengunggah laporan Result beserta Nota** sebagai bukti.</p>
                            
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('pengajuan.cetak', $pengajuan->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-emerald-700 font-bold px-5 py-2.5 rounded-xl border border-emerald-300 hover:bg-emerald-100 transition-colors shadow-sm text-sm">
                                    <i class="fas fa-file-pdf"></i> Unduh SPPD
                                </a>
                                <a href="{{ route('pengajuan.klaim', $pengajuan->id) }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors shadow-sm text-sm">
                                    <i class="fas fa-cloud-upload-alt"></i> Upload Result / Nota
                                </a>
                            </div>
                        </div>
                    @elseif($pengajuan->status === 'selesai')
                        <div class="mt-8 bg-brand-50 border border-brand-200 rounded-2xl p-5 shadow-sm">
                            <h6 class="font-bold text-brand-700 mb-1 flex items-center gap-2"><i class="fas fa-check-double"></i> Perjalanan Dinas Tuntas 100%</h6>
                            <p class="text-sm text-brand-600 mb-4">Terima kasih, Anda telah mengunggah Laporan Hasil Kunjungan dan Nota dengan sukses. Seluruh proses dokumen ini telah selesai.</p>
                            
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('pengajuan.cetak', $pengajuan->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-brand-700 font-bold px-5 py-2.5 rounded-xl border border-brand-300 hover:bg-brand-100 transition-colors shadow-sm text-sm">
                                    <i class="fas fa-file-pdf"></i> Arsip SPPD
                                </a>
                                <a href="{{ route('pengajuan.result.pdf', $pengajuan->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-600 text-white font-bold px-5 py-2.5 rounded-xl hover:bg-brand-700 transition-colors shadow-sm text-sm">
                                    <i class="fas fa-file-contract"></i> Unduh PDF Result
                                </a>
                            </div>
                        </div>
                    @elseif($pengajuan->status === 'pending_l1' || $pengajuan->status === 'pending_l2')
                        <div class="mt-8 bg-slate-50 border border-slate-200 rounded-2xl p-5 shadow-sm text-center">
                            <i class="fas fa-hourglass-half text-slate-400 text-2xl mb-2"></i>
                            <h6 class="font-bold text-slate-700 mb-1">Dokumen Sedang Diproses</h6>
                            <p class="text-sm text-slate-500 m-0">Harap menunggu hingga atasan Anda memberikan persetujuan atau keputusan.</p>
                        </div>
                    @endif
                </div>

                <!-- DETAIL PENGAJUAN CARD -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-soft p-6 md:p-8">
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b border-slate-100 pb-5 gap-4">
                        <div>
                            <h4 class="text-xl font-bold text-slate-800 mb-1">Dokumen UPCOUNTRY (UC)</h4>
                            <p class="text-slate-500 text-sm m-0">Tanggal Dibuat: {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d F Y, H:i') }} WITA</p>
                        </div>
                        <span class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold shadow-sm flex items-center gap-2">
                            <i class="fas fa-hashtag text-slate-400"></i> UC-{{ sprintf('%04d', $pengajuan->id) }}
                        </span>
                    </div>

                    <!-- Rute & Jadwal -->
                    <div class="mb-8">
                        <h6 class="text-sm font-bold text-brand-600 uppercase tracking-wider flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                            <i class="fas fa-map-marked-alt text-lg"></i> Rute & Jadwal
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Rute Perjalanan</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 flex items-center flex-wrap gap-2">
                                    {{ $pengajuan->departure }} <i class="fas fa-arrow-right text-slate-400 text-[10px]"></i> <span class="text-brand-600">{{ $pengajuan->destination }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Pelaksanaan</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800">
                                    <i class="far fa-calendar-alt text-slate-400 mr-2"></i> {{ \Carbon\Carbon::parse($pengajuan->start_date)->format('d M Y') }} <span class="text-slate-400 mx-1">s/d</span> {{ \Carbon\Carbon::parse($pengajuan->end_date)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tim & Operasional -->
                    <div class="mb-8">
                        <h6 class="text-sm font-bold text-brand-600 uppercase tracking-wider flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                            <i class="fas fa-users text-lg"></i> Tim & Operasional
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Transportasi</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 flex items-center gap-3">
                                    @if($pengajuan->transportation_type == 'Darat')
                                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center"><i class="fas fa-car"></i></div>
                                        Darat 
                                        @if($pengajuan->vehicle_number)
                                            <span class="bg-slate-200 text-slate-600 text-xs px-2 py-1 rounded-md ml-auto">{{ $pengajuan->vehicle_number }}</span>
                                        @endif
                                    @elseif($pengajuan->transportation_type == 'Udara')
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
                                    @if($pengajuan->companion_1 || $pengajuan->companion_2)
                                        <ul class="m-0 pl-4 space-y-1">
                                            @if($pengajuan->companion_1) <li>{{ $pengajuan->companion_1 }}</li> @endif
                                            @if($pengajuan->companion_2) <li>{{ $pengajuan->companion_2 }}</li> @endif
                                        </ul>
                                    @else
                                        <span class="text-slate-400 italic">Berangkat sendiri (Tidak ada)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rincian Biaya (Hanya tampil jika sudah diproses atau ada estimasi) -->
                    @if($pengajuan->total_biaya > 0)
                    <div class="mb-4">
                        <h6 class="text-sm font-bold text-brand-600 uppercase tracking-wider flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                            <i class="fas fa-file-invoice-dollar text-lg"></i> Estimasi Biaya
                        </h6>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Uang Makan</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 text-center">
                                    Rp {{ number_format($pengajuan->biaya_makan ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Penginapan</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 text-center">
                                    Rp {{ number_format($pengajuan->biaya_penginapan ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Bensin / Trans.</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 text-center">
                                    Rp {{ number_format($pengajuan->biaya_bensin ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-black text-brand-600 uppercase tracking-wider mb-2">Total Disetujui</p>
                                <div class="bg-gradient-to-br from-brand-600 to-indigo-600 border border-brand-500 rounded-xl px-4 py-3 text-sm font-black text-white text-center shadow-md">
                                    Rp {{ number_format($pengajuan->total_biaya ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Riwayat Catatan Pimpinan -->
                    @if($pengajuan->l1_note || $pengajuan->l2_note)
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <h6 class="font-bold text-slate-700 mb-4 flex items-center gap-2"><i class="fas fa-comments text-slate-400"></i> Catatan Pimpinan:</h6>
                            
                            @if($pengajuan->l1_note)
                            <div class="bg-amber-50 border-l-4 border-amber-500 rounded-r-xl p-4 mb-3 shadow-sm">
                                <p class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-1">Manajer (L1)</p>
                                <p class="text-sm text-amber-900 m-0 italic">"{{ $pengajuan->l1_note }}"</p>
                            </div>
                            @endif
                            
                            @if($pengajuan->l2_note)
                            <div class="bg-brand-50 border-l-4 border-brand-500 rounded-r-xl p-4 shadow-sm">
                                <p class="text-xs font-bold text-brand-800 uppercase tracking-wider mb-1">Finance (L2)</p>
                                <p class="text-sm text-brand-900 m-0 italic">"{{ $pengajuan->l2_note }}"</p>
                            </div>
                            @endif
                        </div>
                    @endif

                </div>
                @endif

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
        });
    </script>
</body>
</html>