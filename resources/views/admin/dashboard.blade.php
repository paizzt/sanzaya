<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Satu Sanzaya</title>
    
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
        .nav-right { display: flex; align-items: center; gap: 25px; }
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
        
        /* Warna Khusus Tiap Kartu */
        .card-blue .stat-icon { background: #E5F0FF; color: #0A539B; }
        .card-orange .stat-icon { background: #FFF3E0; color: #F57C00; }
        .card-green .stat-icon { background: #E8F5E9; color: #2E7D32; }
        .card-purple .stat-icon { background: #F3E5F5; color: #8E24AA; }

        .stat-info h3 { font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .stat-info p { font-size: 13px; font-weight: 500; color: var(--text-gray); margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }

        /* --- LIST CARD (Pengguna Terbaru & UC) --- */
        .list-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 25px; height: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .list-card-title { font-size: 16px; font-weight: 700; color: var(--text-dark); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        
        .list-item { display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-bottom: 1px dashed var(--border-color); }
        .list-item:last-child { border-bottom: none; padding-bottom: 0; }
        .item-left { display: flex; align-items: center; gap: 15px; }
        .item-avatar { width: 40px; height: 40px; border-radius: 50%; background: #F1F5F9; display: flex; align-items: center; justify-content: center; font-weight: 600; color: var(--primary-blue); font-size: 14px; }
        
        .badge-status { font-size: 11px; padding: 5px 10px; border-radius: 6px; font-weight: 600; }

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

    <!-- MENGAMBIL DATA STATISTIK LANGSUNG (DROP-IN REPLACEMENT) -->
    @php
        $totalUsers = \App\Models\User::count();
        $totalUC = \App\Models\TravelRequest::count();
        $pendingUC = \App\Models\TravelRequest::whereIn('status', ['pending_l1', 'pending_l2'])->count();
        $approvedUC = \App\Models\TravelRequest::where('status', 'approved')->count();

        $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get();
        $recentUC = \App\Models\TravelRequest::with('user')->orderBy('created_at', 'desc')->take(5)->get();
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('admin.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item active"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Perubahan</span></a></li>
                <li><a href="{{ route('admin.users.index') ?? '#' }}" class="menu-item"><i class="fas fa-users menu-icon"></i><span class="menu-text">Kelola data</span></a></li>
                <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                <li><a href="{{ route('admin.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Beranda Administrator</h5>
                </div>
                <div class="nav-right">
                    <div class="nav-icon"><i class="far fa-bell"></i><div class="badge-dot"></div></div>
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Admin Name' }}</p>
                            <p class="user-role">admin</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--text-dark);">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!</h4>
                        <p class="text-muted small m-0">Berikut adalah ringkasan sistem Satu Sanzaya hari ini.</p>
                    </div>
                    <div class="d-none d-md-block text-end">
                        <p class="text-muted small m-0 fst-italic">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                <!-- ROW 1: KARTU STATISTIK -->
                <div class="row g-4 mb-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-blue">
                            <div class="stat-icon"><i class="fas fa-users"></i></div>
                            <div class="stat-info">
                                <h3>{{ $totalUsers }}</h3>
                                <p>Total Pengguna</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-purple">
                            <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
                            <div class="stat-info">
                                <h3>{{ $totalUC }}</h3>
                                <p>Total UC</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-orange">
                            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                            <div class="stat-info">
                                <h3>{{ $pendingUC }}</h3>
                                <p>Proses Validasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-green">
                            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="stat-info">
                                <h3>{{ $approvedUC }}</h3>
                                <p>UC Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: DAFTAR TERBARU -->
                <div class="row g-4">
                    
                    <!-- PENGGUNA TERBARU -->
                    <div class="col-lg-6">
                        <div class="list-card">
                            <div class="list-card-title">
                                <span><i class="fas fa-user-plus text-primary me-2"></i> Pengguna Baru Ditambahkan</span>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light border text-primary" style="font-size: 11px; font-weight: 600;">Lihat Semua</a>
                            </div>
                            
                            <div class="list-container">
                                @forelse($recentUsers as $u)
                                <div class="list-item">
                                    <div class="item-left">
                                        <div class="item-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                        <div>
                                            <p class="m-0 fw-bold text-dark" style="font-size: 13px;">{{ $u->name }}</p>
                                            <p class="m-0 text-muted" style="font-size: 11px;">{{ $u->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark border text-capitalize" style="font-size: 10px;">{{ $u->role }}</span>
                                        <p class="m-0 text-muted mt-1" style="font-size: 10px;">{{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted small">Belum ada pengguna di sistem.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- UC TERBARU -->
                    <div class="col-lg-6">
                        <div class="list-card">
                            <div class="list-card-title">
                                <span><i class="fas fa-paper-plane text-success me-2"></i> Pengajuan UC Terbaru</span>
                            </div>
                            
                            <div class="list-container">
                                @forelse($recentUC as $UC)
                                <div class="list-item">
                                    <div class="item-left">
                                        <div class="item-avatar" style="background: #ECFDF5; color: #10B981;"><i class="fas fa-car-side"></i></div>
                                        <div>
                                            <p class="m-0 fw-bold text-dark" style="font-size: 13px;">Tujuan: {{ $UC->destination }}</p>
                                            <p class="m-0 text-muted" style="font-size: 11px;">Oleh: {{ $UC->user->name ?? 'User Dihapus' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        @if($UC->status == 'pending_l1')
                                            <span class="badge-status bg-warning text-dark border border-warning" style="background-color: #FFFBEB !important; color: #B45309 !important;">Cek Manajer</span>
                                        @elseif($UC->status == 'pending_l2')
                                            <span class="badge-status bg-info text-dark border border-info" style="background-color: #EFF6FF !important; color: #1D4ED8 !important;">Cek Finance</span>
                                        @elseif($UC->status == 'approved')
                                            <span class="badge-status bg-success text-dark border border-success" style="background-color: #ECFDF5 !important; color: #047857 !important;">Selesai</span>
                                        @elseif($UC->status == 'rejected')
                                            <span class="badge-status bg-danger text-dark border border-danger" style="background-color: #FEF2F2 !important; color: #B91C1C !important;">Ditolak</span>
                                        @endif
                                        <p class="m-0 text-muted mt-1" style="font-size: 10px;">{{ \Carbon\Carbon::parse($UC->created_at)->format('d M') }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted small">Belum ada riwayat pengajuan UC.</div>
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