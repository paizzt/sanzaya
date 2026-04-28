<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff - Satu Sanzaya</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0A539B;
            --light-blue: #E5F0FF;
            --sidebar-bg: #FAFAFA;
            --text-dark: #333333;
            --text-gray: #888888;
            --border-color: #EAEAEA;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px; 
        }

        body { font-family: 'Poppins', sans-serif; background-color: #F8F9FA; margin: 0; overflow-x: hidden; }
        .wrapper { display: flex; height: 100vh; }

        /* --- SIDEBAR KONSISTEN --- */
        .sidebar { width: var(--sidebar-width); background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; transition: all 0.3s ease; position: relative; z-index: 100; height: 100vh; }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .logo-area { height: 80px; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
        .logo-img { max-width: 140px; transition: 0.3s; }
        .sidebar.collapsed .logo-img { max-width: 40px; }
        .sidebar-menu { list-style: none; padding: 20px 10px; margin: 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; padding: 12px 20px; color: var(--text-gray); text-decoration: none; border-radius: 10px; margin-bottom: 5px; transition: 0.2s; font-weight: 500; font-size: 14px; white-space: nowrap; overflow: hidden; }
        .menu-item:hover { background-color: var(--border-color); color: var(--text-dark); }
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); font-weight: 600;}
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }

        /* --- MAIN CONTENT & NAVBAR --- */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; width: calc(100% - var(--sidebar-width)); transition: width 0.3s ease; }
        .sidebar.collapsed ~ .main-content { width: calc(100% - var(--sidebar-collapsed-width)); }
        .top-navbar { height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; }
        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; }
        .nav-right { display: flex; align-items: center; gap: 25px; position: relative; } /* Relative untuk dropdown */
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: lowercase; }
        .user-avatar { font-size: 32px; color: var(--text-dark); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- DASHBOARD CARDS --- */
        .stat-card { background: #FFFFFF; border-radius: 16px; padding: 25px; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 20px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.05); }
        .stat-icon { width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        
        .card-blue .stat-icon { background: #E5F0FF; color: #0A539B; }
        .card-orange .stat-icon { background: #FFF3E0; color: #F57C00; }
        .card-green .stat-icon { background: #E8F5E9; color: #2E7D32; }
        .card-red .stat-icon { background: #FEF2F2; color: #DC2626; }

        .stat-info h3 { font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .stat-info p { font-size: 13px; font-weight: 500; color: var(--text-gray); margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }

        /* --- QUICK ACTION & LIST CARD --- */
        .action-card { background: linear-gradient(135deg, var(--primary-blue), #1e3a8a); border-radius: 16px; padding: 30px; color: white; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; height: 100%; box-shadow: 0 10px 20px rgba(10,83,155,0.2); position: relative; overflow: hidden; }
        .action-card::after { content: '\f1d8'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; right: -20px; bottom: -30px; font-size: 150px; color: rgba(255,255,255,0.1); transform: rotate(-15deg); }
        .action-card h4 { font-weight: 700; margin-bottom: 10px; position: relative; z-index: 2; }
        .action-card p { font-size: 13px; opacity: 0.9; margin-bottom: 20px; position: relative; z-index: 2; max-width: 80%; }
        .btn-light-custom { background: white; color: var(--primary-blue); font-weight: 600; padding: 12px 25px; border-radius: 10px; text-decoration: none; display: inline-block; position: relative; z-index: 2; transition: 0.3s; }
        .btn-light-custom:hover { background: #F8FAFC; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); color: var(--primary-blue); }

        .list-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 25px; height: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .list-card-title { font-size: 16px; font-weight: 700; color: var(--text-dark); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        
        .list-item { display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-bottom: 1px dashed var(--border-color); }
        .list-item:last-child { border-bottom: none; padding-bottom: 0; }
        .item-left { display: flex; align-items: center; gap: 15px; }
        .item-icon { width: 40px; height: 40px; border-radius: 10px; background: #F8FAFC; display: flex; align-items: center; justify-content: center; color: var(--text-gray); font-size: 16px; }
        
        .badge-status { font-size: 11px; padding: 5px 10px; border-radius: 6px; font-weight: 600; }

        /* --- NOTIFIKASI DROPDOWN --- */
        .nav-icon { position: relative; cursor: pointer; }
        .badge-dot { position: absolute; top: 0; right: 0; width: 8px; height: 8px; background-color: #EF4444; border-radius: 50%; display: none; }
        .badge-dot.active { display: block; }
        
        .notification-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            width: 320px;
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }
        .notification-dropdown.show { display: block; }
        .notification-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--text-dark);
            background-color: #FAFAFA;
        }
        .notification-list {
            max-height: 300px;
            overflow-y: auto;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            align-items: start;
            gap: 15px;
            transition: background-color 0.2s;
        }
        .notification-item:hover { background-color: #F8FAFC; }
        .notification-item:last-child { border-bottom: none; }
        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .notif-success { background-color: #ECFDF5; color: #10B981; }
        .notif-warning { background-color: #FFFBEB; color: #D97706; }
        .notif-danger { background-color: #FEF2F2; color: #EF4444; }
        .notif-info { background-color: #EFF6FF; color: #3B82F6; }

        .notification-content p { margin: 0; font-size: 13px; color: var(--text-dark); line-height: 1.4; }
        .notification-content span { font-size: 11px; color: var(--text-gray); }

        /* --- RESPONSIVE --- */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content, .sidebar.collapsed ~ .main-content { width: 100%; }
            .top-navbar { padding: 0 20px; }
            .content-area { padding: 20px; }
            .user-role { display: none; }
            .action-card::after { font-size: 100px; right: -10px; bottom: -20px; }
        }
    </style>
</head>
<body>

    <!-- MENGAMBIL DATA STATISTIK PRIBADI STAFF LANGSUNG -->
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        $totalPengajuan = \App\Models\TravelRequest::where('user_id', $userId)->count();
        $sedangProses = \App\Models\TravelRequest::where('user_id', $userId)->whereIn('status', ['pending_l1', 'pending_l2'])->count();
        $disetujui = \App\Models\TravelRequest::where('user_id', $userId)->where('status', 'approved')->count();
        $ditolak = \App\Models\TravelRequest::where('user_id', $userId)->where('status', 'rejected')->count();

        $riwayatTerbaru = \App\Models\TravelRequest::where('user_id', $userId)->latest()->take(5)->get();

        // Logika Notifikasi khusus Staff (Memantau status dokumen mereka sendiri)
        $notifications = \App\Models\TravelRequest::where('user_id', $userId)
                            ->orderBy('updated_at', 'desc')
                            ->take(5)
                            ->get();
        $hasNewNotif = $notifications->count() > 0;
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('staff.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('staff.dashboard') ?? '#' }}" class="menu-item active"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('staff.riwayat') ?? '#' }}" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
                <li><a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="menu-item"><i class="fas fa-file-lines menu-icon"></i><span class="menu-text">Pengajuan UC</span></a></li>
                <li><a href="{{ route('staff.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
                <a href="#" class="menu-item" style="color: var(--text-gray);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right-from-bracket menu-icon"></i><span class="menu-text">Keluar</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Beranda Karyawan</h5>
                </div>
                <div class="nav-right">
                    
                    <!-- AREA NOTIFIKASI -->
                    <div class="nav-icon" id="notificationToggle">
                        <i class="far fa-bell" style="font-size: 20px;"></i>
                        <div class="badge-dot {{ $hasNewNotif ? 'active' : '' }}"></div>
                        
                        <!-- DROPDOWN NOTIFIKASI STAFF -->
                        <div class="notification-dropdown" id="notificationDropdown">
                            <div class="notification-header">
                                Notifikasi Pengajuan Saya
                            </div>
                            <ul class="notification-list">
                                @forelse($notifications as $notif)
                                    @php
                                        // Set style notif berdasarkan status
                                        $notifIcon = 'fa-file-alt';
                                        $notifClass = 'notif-info';
                                        $statusText = 'Sedang diproses';
                                        
                                        if($notif->status == 'pending_l1') { $notifClass = 'notif-warning'; $notifIcon = 'fa-hourglass-half'; $statusText = 'Menunggu ACC Manajer'; }
                                        if($notif->status == 'pending_l2') { $notifClass = 'notif-info'; $notifIcon = 'fa-money-check'; $statusText = 'Menunggu Pencairan Finance'; }
                                        if($notif->status == 'approved') { $notifClass = 'notif-success'; $notifIcon = 'fa-check-circle'; $statusText = 'Disetujui & Dicairkan'; }
                                        if($notif->status == 'rejected') { $notifClass = 'notif-danger'; $notifIcon = 'fa-times-circle'; $statusText = 'Ditolak'; }
                                    @endphp
                                    <li class="notification-item" onclick="window.location.href='{{ route('staff.riwayat') ?? '#' }}'" style="cursor: pointer;">
                                        <div class="notification-icon {{ $notifClass }}"><i class="fas {{ $notifIcon }}"></i></div>
                                        <div class="notification-content">
                                            <p>Pengajuan ke <strong>{{ $notif->destination }}</strong>: <br><span style="color: var(--text-dark); font-weight: 500;">{{ $statusText }}</span></p>
                                            <span>Update: {{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="notification-item"><div class="notification-content"><p class="text-muted text-center w-100">Belum ada pembaruan status.</p></div></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <!-- END AREA NOTIFIKASI -->

                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama Staff' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'staff' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar" style="color: var(--primary-blue);"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--text-dark);">Halo, {{ Auth::user()->name ?? 'Karyawan' }}! 👋</h4>
                        <p class="text-muted small m-0">Pantau status pengajuan perjalanan dinas (UC) Anda di sini.</p>
                    </div>
                    <div class="d-none d-md-block text-end">
                        <p class="text-muted small m-0 fst-italic">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                <!-- ROW 1: KARTU STATISTIK -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-blue">
                            <div class="stat-icon"><i class="fas fa-copy"></i></div>
                            <div class="stat-info">
                                <h3>{{ $totalPengajuan }}</h3>
                                <p>Total SPPD Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-orange">
                            <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                            <div class="stat-info">
                                <h3>{{ $sedangProses }}</h3>
                                <p>Sedang Diproses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-green">
                            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="stat-info">
                                <h3>{{ $disetujui }}</h3>
                                <p>Telah Disetujui</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-red">
                            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                            <div class="stat-info">
                                <h3>{{ $ditolak }}</h3>
                                <p>Ditolak / Batal</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: ACTION & RIWAYAT TERBARU -->
                <div class="row g-4">
                    
                    <!-- KARTU BUAT PENGAJUAN -->
                    <div class="col-lg-5">
                        <div class="action-card">
                            <h4>Rencana Perjalanan Dinas?</h4>
                            <p>Ajukan perjalanan dinas (UC) Anda sekarang. Isi formulir dengan lengkap untuk memudahkan proses persetujuan oleh Manajer dan Finance.</p>
                            <a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="btn-light-custom">
                                Buat Pengajuan Baru <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- RIWAYAT PENGAJUAN TERBARU -->
                    <div class="col-lg-7">
                        <div class="list-card">
                            <div class="list-card-title">
                                <span><i class="fas fa-history text-primary me-2"></i> Riwayat Pengajuan Terbaru Anda</span>
                                <a href="{{ route('staff.riwayat') ?? '#' }}" class="btn btn-sm btn-light border text-primary" style="font-size: 11px; font-weight: 600;">Lihat Semua</a>
                            </div>
                            
                            <div class="list-container">
                                @forelse($riwayatTerbaru as $sppd)
                                <div class="list-item">
                                    <div class="item-left">
                                        <div class="item-icon">
                                            @if($sppd->status == 'approved')
                                                <i class="fas fa-check text-success"></i>
                                            @elseif($sppd->status == 'rejected')
                                                <i class="fas fa-times text-danger"></i>
                                            @else
                                                <i class="fas fa-paper-plane text-warning"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="m-0 fw-bold text-dark" style="font-size: 13px;">Tujuan: {{ $sppd->destination }}</p>
                                            <p class="m-0 text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($sppd->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($sppd->end_date)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        @if($sppd->status == 'pending_l1')
                                            <span class="badge-status bg-warning text-dark border border-warning" style="background-color: #FFFBEB !important; color: #B45309 !important;">Cek Manajer</span>
                                        @elseif($sppd->status == 'pending_l2')
                                            <span class="badge-status bg-info text-dark border border-info" style="background-color: #EFF6FF !important; color: #1D4ED8 !important;">Cek Finance</span>
                                        @elseif($sppd->status == 'approved')
                                            <span class="badge-status bg-success text-dark border border-success" style="background-color: #ECFDF5 !important; color: #047857 !important;">Selesai & Lolos</span>
                                        @elseif($sppd->status == 'rejected')
                                            <span class="badge-status bg-danger text-dark border border-danger" style="background-color: #FEF2F2 !important; color: #B91C1C !important;">Ditolak</span>
                                        @endif
                                        <p class="m-0 text-muted mt-1" style="font-size: 10px;">Dikirim: {{ \Carbon\Carbon::parse($sppd->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted small">
                                    <i class="fas fa-folder-open fa-2x mb-2" style="color: #CBD5E1;"></i><br>
                                    Anda belum memiliki riwayat pengajuan SPPD.
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // --- LOGIKA NOTIFIKASI DROPDOWN ---
        const notificationToggle = document.getElementById('notificationToggle');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const badgeDot = document.querySelector('.badge-dot');

        if(notificationToggle) {
            notificationToggle.addEventListener('click', function(event) {
                event.stopPropagation(); // Mencegah klik menyebar ke window
                notificationDropdown.classList.toggle('show');
                // Jika dropdown dibuka, sembunyikan titik merah
                if(notificationDropdown.classList.contains('show') && badgeDot) {
                    badgeDot.classList.remove('active');
                }
            });

            // Tutup dropdown jika klik di luar area
            window.addEventListener('click', function(event) {
                if (!notificationToggle.contains(event.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }

        // --- LOGIKA RESPONSIVE SIDEBAR ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-active');
                overlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        });
        
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-active');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>