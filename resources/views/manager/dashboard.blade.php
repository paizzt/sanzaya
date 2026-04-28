<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajer - Satu Sanzaya</title>
    
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
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: capitalize; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- DASHBOARD CARDS --- */
        .stat-card { background: #FFFFFF; border-radius: 16px; padding: 25px; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 20px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.05); }
        .stat-icon { width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        
        .card-orange .stat-icon { background: #FFFBEB; color: #D97706; }
        .card-green .stat-icon { background: #ECFDF5; color: #10B981; }
        .card-red .stat-icon { background: #FEF2F2; color: #EF4444; }
        .card-blue .stat-icon { background: #EFF6FF; color: #3B82F6; }

        .stat-info h3 { font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .stat-info p { font-size: 13px; font-weight: 500; color: var(--text-gray); margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }

        /* --- QUICK ACTION & LIST CARD --- */
        .action-card { background: linear-gradient(135deg, #F59E0B, #D97706); border-radius: 16px; padding: 30px; color: white; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; height: 100%; box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2); position: relative; overflow: hidden; }
        .action-card::after { content: '\f0e7'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; right: -10px; bottom: -20px; font-size: 150px; color: rgba(255,255,255,0.1); transform: rotate(-15deg); }
        .action-card h4 { font-weight: 700; margin-bottom: 10px; position: relative; z-index: 2; }
        .action-card p { font-size: 13px; opacity: 0.9; margin-bottom: 20px; position: relative; z-index: 2; max-width: 90%; }
        .btn-light-custom { background: white; color: #D97706; font-weight: 600; padding: 12px 25px; border-radius: 10px; text-decoration: none; display: inline-block; position: relative; z-index: 2; transition: 0.3s; }
        .btn-light-custom:hover { background: #FFFBEB; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); color: #B45309; }

        .list-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 25px; height: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .list-card-title { font-size: 16px; font-weight: 700; color: var(--text-dark); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        
        .list-item { display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-bottom: 1px dashed var(--border-color); }
        .list-item:last-child { border-bottom: none; padding-bottom: 0; }
        .item-left { display: flex; align-items: center; gap: 15px; }
        .item-icon { width: 40px; height: 40px; border-radius: 10px; background: #FFFBEB; display: flex; align-items: center; justify-content: center; color: #D97706; font-size: 16px; }
        
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
            .action-card::after { font-size: 100px; right: -10px; bottom: -20px; }
        }
    </style>
</head>
<body>

    <!-- MENGAMBIL DATA STATISTIK MANAGER LANGSUNG -->
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        // Menghitung jumlah UC yang menunggu ACC Manajer
        $menungguAcc = \App\Models\TravelRequest::where('status', 'pending_l1')->count();
        
        // Menghitung UC yang sudah diproses oleh Manajer ini
        $disetujuiManager = \App\Models\TravelRequest::where('l1_approver_id', $userId)
                              ->whereIn('status', ['pending_l2', 'approved'])
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
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('manager.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item active"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Persetujuan UC</span></a></li>
                <li><a href="{{ route('manager.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Proses</span></a></li>
                <!-- Jika Manager boleh buat pengajuan, menu ini dimunculkan. Jika tidak, bisa dihapus -->
                <li><a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item"><i class="fas fa-paper-plane menu-icon"></i><span class="menu-text">Buat Pengajuan</span></a></li>
                <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                <li><a href="{{ route('manager.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Beranda Validator (L1)</h5>
                </div>
                <div class="nav-right">
                    <div class="nav-icon position-relative">
                        <i class="far fa-bell"></i>
                        @if($menungguAcc > 0)
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                        @endif
                    </div>
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama Manajer' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'manager' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--text-dark);">Halo, {{ Auth::user()->name ?? 'Manajer' }}! 👋</h4>
                        <p class="text-muted small m-0">Berikut adalah ringkasan pengajuan perjalanan dinas tim Anda.</p>
                    </div>
                    <div class="d-none d-md-block text-end">
                        <p class="text-muted small m-0 fst-italic">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                <!-- ROW 1: KARTU STATISTIK -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-orange">
                            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                            <div class="stat-info">
                                <h3>{{ $menungguAcc }}</h3>
                                <p>Menunggu ACC</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-green">
                            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                            <div class="stat-info">
                                <h3>{{ $disetujuiManager }}</h3>
                                <p>Telah Di-ACC</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-red">
                            <div class="stat-icon"><i class="fas fa-ban"></i></div>
                            <div class="stat-info">
                                <h3>{{ $ditolakManager }}</h3>
                                <p>Ditolak</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card card-blue">
                            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                            <div class="stat-info">
                                <h3>{{ $totalDiproses }}</h3>
                                <p>Total Diproses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: ACTION & LIST ANTRIAN TERBARU -->
                <div class="row g-4">
                    
                    <!-- KARTU ALERT ANTRIAN -->
                    <div class="col-lg-5">
                        <div class="action-card">
                            @if($menungguAcc > 0)
                                <h4>Ada {{ $menungguAcc }} Dokumen Tertunda!</h4>
                                <p>Mohon segera meninjau dan memberikan persetujuan (ACC) pada pengajuan UC tim agar dapat segera diproses oleh divisi Finance (Keuangan).</p>
                                <a href="{{ route('approvals.index') ?? '#' }}" class="btn-light-custom">
                                    Tinjau Sekarang <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            @else
                                <h4>Semua Tuntas! 🎉</h4>
                                <p>Kerja bagus! Tidak ada pengajuan UC dari tim yang menunggu persetujuan Anda saat ini. Semua antrean L1 telah diproses.</p>
                                <a href="{{ route('manager.history') ?? '#' }}" class="btn-light-custom" style="background: rgba(255,255,255,0.2); color: white;">
                                    Lihat Riwayat <i class="fas fa-history ms-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- DAFTAR ANTREAN UC -->
                    <div class="col-lg-7">
                        <div class="list-card">
                            <div class="list-card-title">
                                <span><i class="fas fa-inbox text-warning me-2"></i> Antrean Menunggu ACC (L1)</span>
                                <a href="{{ route('approvals.index') ?? '#' }}" class="btn btn-sm btn-light border text-primary" style="font-size: 11px; font-weight: 600;">Lihat Semua</a>
                            </div>
                            
                            <div class="list-container">
                                @forelse($antreanTerbaru as $UC)
                                <div class="list-item">
                                    <div class="item-left">
                                        <div class="item-icon">
                                            <i class="fas fa-user-clock"></i>
                                        </div>
                                        <div>
                                            <p class="m-0 fw-bold text-dark" style="font-size: 13px;">{{ $UC->user->name ?? 'User' }} - {{ $UC->destination }}</p>
                                            <p class="m-0 text-muted" style="font-size: 11px;">
                                                <i class="far fa-calendar-alt me-1"></i> Berangkat: {{ \Carbon\Carbon::parse($UC->start_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('approvals.show', $UC->id) }}" class="btn btn-sm btn-outline-primary" style="font-size: 11px; font-weight: 600; border-radius: 6px;">
                                            Detail & ACC
                                        </a>
                                        <p class="m-0 text-muted mt-1" style="font-size: 10px;">Masuk: {{ \Carbon\Carbon::parse($UC->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted small">
                                    <i class="fas fa-check-circle fa-2x mb-2" style="color: #A7F3D0;"></i><br>
                                    Tidak ada antrean UC yang membutuhkan ACC.
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