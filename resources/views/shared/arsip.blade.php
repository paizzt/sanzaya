<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Seluruh SPPD - Satu Sanzaya</title>
    
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
        .nav-right { display: flex; align-items: center; gap: 25px; position: relative; } /* Tambah relative untuk dropdown */
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: capitalize; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- STYLING HALAMAN ARSIP --- */
        .filter-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); padding: 20px; margin-bottom: 20px; }
        .table-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table th { font-weight: 600; font-size: 12px; color: var(--text-gray); text-transform: uppercase; padding: 15px 20px; background-color: #FAFAFA; border-bottom: 1px solid var(--border-color); letter-spacing: 0.5px; }
        .table td { padding: 15px 20px; vertical-align: middle; font-size: 14px; color: var(--text-dark); border-bottom: 1px dashed var(--border-color); }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background-color: #F8FBFF; }

        .user-info-name { font-weight: 600; color: var(--text-dark); margin: 0; font-size: 13px; }
        .user-info-sub { font-size: 11px; color: var(--text-gray); margin: 0; }

        /* Badge Status */
        .status-pill { padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; }
        .bg-warning-light { background: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; }
        .bg-info-light { background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
        .bg-success-light { background: #ECFDF5; color: #10B981; border: 1px solid #A7F3D0; }
        .bg-danger-light { background: #FEF2F2; color: #EF4444; border: 1px solid #FECACA; }

        /* Action Button */
        .btn-review { background-color: #F8FAFC; color: var(--primary-blue); border: 1px solid #CBD5E1; padding: 6px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn-review:hover { background-color: var(--primary-blue); color: white; border-color: var(--primary-blue); }

        /* --- NOTIFIKASI DROPDOWN --- */
        .nav-icon { position: relative; cursor: pointer; }
        .badge-dot { position: absolute; top: 0; right: 0; width: 8px; height: 8px; background-color: #EF4444; border-radius: 50%; display: none; }
        .badge-dot.active { display: block; }
        
        .notification-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            width: 300px;
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
        .notif-admin { background-color: #EFF6FF; color: #3B82F6; }
        .notif-manager { background-color: #FFFBEB; color: #D97706; }
        .notif-finance { background-color: #ECFDF5; color: #10B981; }
        
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
        }
    </style>
</head>
<body>

    <!-- MENGAMBIL SELURUH DATA ARSIP DAN NOTIFIKASI -->
    @php
        $userRole = strtolower(trim(Auth::user()->role));
        // Tarik semua data arsip
        $requests = \App\Models\TravelRequest::with('user')->orderBy('created_at', 'desc')->get();
        
        // Logika Data Notifikasi Berdasarkan Role
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

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR PINTAR -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ url('/home') }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                @if($userRole === 'admin')
                    <li><a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                    <li><a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Perubahan</span></a></li>
                    <li><a href="{{ route('admin.users.index') ?? '#' }}" class="menu-item"><i class="fas fa-users menu-icon"></i><span class="menu-text">Kelola data</span></a></li>
                    <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item active"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip Seluruh Sistem</span></a></li>
                    <li><a href="{{ route('admin.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
                @elseif(in_array($userRole, ['manager', 'hrd', 'kepala marketing']))
                    <li><a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                    <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Persetujuan SPPD</span></a></li>
                    <li><a href="{{ route('manager.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Proses</span></a></li>
                    <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item active"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                    <li><a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item"><i class="fas fa-paper-plane menu-icon"></i><span class="menu-text">Buat Pengajuan</span></a></li>
                    <li><a href="{{ route('manager.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
                @elseif($userRole == 'finance')
                    <li><a href="{{ route('finance.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                    <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-invoice-dollar menu-icon"></i><span class="menu-text">Antrean Pencairan</span></a></li>
                    <li><a href="{{ route('finance.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Pencairan</span></a></li>
                    <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item active"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                    <li><a href="{{ route('finance.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
                @endif
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Arsip Seluruh Dokumen UC</h5>
                </div>
                <div class="nav-right">
                    
                    <!-- AREA NOTIFIKASI -->
                    <div class="nav-icon" id="notificationToggle">
                        <i class="far fa-bell" style="font-size: 20px;"></i>
                        <div class="badge-dot {{ $hasNewNotif ? 'active' : '' }}"></div>
                        
                        <!-- DROPDOWN NOTIFIKASI -->
                        <div class="notification-dropdown" id="notificationDropdown">
                            <div class="notification-header">
                                Notifikasi Terkini
                            </div>
                            <ul class="notification-list">
                                @if($userRole === 'admin')
                                    @forelse($notifications as $log)
                                        <li class="notification-item">
                                            <div class="notification-icon notif-admin"><i class="fas fa-history"></i></div>
                                            <div class="notification-content">
                                                <p><strong>{{ $log->user->name ?? 'Sistem' }}</strong>: {{ $log->description }}</p>
                                                <span>{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="notification-item"><div class="notification-content"><p class="text-muted text-center w-100">Belum ada riwayat aktivitas.</p></div></li>
                                    @endforelse
                                @elseif(in_array($userRole, ['manager', 'hrd', 'kepala marketing']))
                                    @forelse($notifications as $notif)
                                        <li class="notification-item" onclick="window.location.href='{{ route('approvals.show', $notif->id) }}'" style="cursor: pointer;">
                                            <div class="notification-icon notif-manager"><i class="fas fa-file-signature"></i></div>
                                            <div class="notification-content">
                                                <p>Pengajuan UC baru dari <strong>{{ $notif->user->name ?? 'Staff' }}</strong> ({{ $notif->destination }}) menunggu persetujuan Anda.</p>
                                                <span>{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="notification-item"><div class="notification-content"><p class="text-muted text-center w-100">Tidak ada pengajuan baru.</p></div></li>
                                    @endforelse
                                @elseif($userRole === 'finance')
                                    @forelse($notifications as $notif)
                                        <li class="notification-item" onclick="window.location.href='{{ route('approvals.show', $notif->id) }}'" style="cursor: pointer;">
                                            <div class="notification-icon notif-finance"><i class="fas fa-file-invoice-dollar"></i></div>
                                            <div class="notification-content">
                                                <p>Pengajuan UC <strong>{{ $notif->user->name ?? 'Staff' }}</strong> ({{ $notif->destination }}) telah disetujui Manajer dan menunggu pencairan dana.</p>
                                                <span>{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="notification-item"><div class="notification-content"><p class="text-muted text-center w-100">Tidak ada dokumen untuk dicairkan.</p></div></li>
                                    @endforelse
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- END AREA NOTIFIKASI -->

                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama User' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'Role' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <!-- Filter Card -->
                <div class="filter-card">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Cari Pegawai / Kota</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Ketik kata kunci...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Filter Status</label>
                            <select class="form-select">
                                <option value="">Semua Arsip</option>
                                <option value="pending_l1">Menunggu L1</option>
                                <option value="pending_l2">Menunggu L2 (Finance)</option>
                                <option value="approved">Selesai (Cair)</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Urutkan</label>
                            <select class="form-select">
                                <option value="terbaru">Terbaru Dibuat</option>
                                <option value="terlama">Paling Lama</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn w-100" style="background: var(--primary-blue); color: white; border-radius: 8px; height: 38px; font-size: 13px; font-weight: 600;">
                                <i class="fas fa-filter me-1"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card table-responsive">
                    <table class="table table-borderless mb-0 align-middle">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Profil Pemohon</th>
                                <th style="width: 25%;">Tujuan & Durasi</th>
                                <th style="width: 15%;">Tgl Pengajuan</th>
                                <th style="width: 20%;">Status Terakhir</th>
                                <th style="width: 15%; text-align: center;">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="user-info-name">{{ $req->user->name ?? 'User Dihapus' }}</p>
                                                <p class="user-info-sub">{{ ucfirst($req->user->role ?? '') }} {{ $req->user->division ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-bold text-dark" style="font-size: 13px;">{{ $req->departure }} <i class="fas fa-arrow-right mx-1 text-muted"></i> {{ $req->destination }}</p>
                                        <p class="mb-0 text-muted" style="font-size: 11px;">
                                            <i class="far fa-calendar-alt me-1"></i> 
                                            {{ \Carbon\Carbon::parse($req->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-dark" style="font-size: 13px;">{{ \Carbon\Carbon::parse($req->created_at)->format('d M Y') }}</p>
                                        <p class="mb-0 text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($req->created_at)->format('H:i') }} WITA</p>
                                    </td>
                                    <td>
                                        @if($req->status == 'pending_l1')
                                            <span class="status-pill bg-warning-light"><i class="fas fa-hourglass-half"></i> Menunggu Manajer</span>
                                        @elseif($req->status == 'pending_l2')
                                            <span class="status-pill bg-info-light"><i class="fas fa-money-check"></i> Menunggu Finance</span>
                                        @elseif($req->status == 'approved')
                                            <span class="status-pill bg-success-light"><i class="fas fa-check-circle"></i> Selesai (Cair)</span>
                                        @elseif($req->status == 'rejected')
                                            <span class="status-pill bg-danger-light"><i class="fas fa-times-circle"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('approvals.show', $req->id) }}" class="btn-review">
                                            <i class="far fa-eye me-1"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-archive fa-3x mb-3" style="color: #CBD5E1;"></i>
                                        <h6 class="fw-bold text-dark mb-1">Arsip Kosong</h6>
                                        <p class="text-muted small mb-0">Belum ada dokumen pengajuan SPPD yang masuk ke dalam sistem.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

        notificationToggle.addEventListener('click', function(event) {
            event.stopPropagation(); // Mencegah klik menyebar ke window
            notificationDropdown.classList.toggle('show');
            // Jika dropdown dibuka, sembunyikan titik merah (opsional, tandanya sudah dibaca)
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