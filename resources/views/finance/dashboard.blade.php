<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Finance - Satu Sanzaya</title>
    
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
            --finance-green: #10B981; /* Warna hijau khas finance */
        }

        body { font-family: 'Poppins', sans-serif; background-color: #F8FAFC; margin: 0; overflow-x: hidden; }
        .wrapper { display: flex; height: 100vh; }

        /* --- SIDEBAR --- */
        .sidebar { width: var(--sidebar-width); background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; transition: all 0.3s ease; position: relative; z-index: 100; height: 100vh; }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .logo-area { height: 80px; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
        .logo-img { max-width: 140px; transition: 0.3s; }
        .sidebar.collapsed .logo-img { max-width: 40px; }
        .sidebar-menu { list-style: none; padding: 20px 10px; margin: 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; padding: 12px 20px; color: var(--text-gray); text-decoration: none; border-radius: 10px; margin-bottom: 5px; transition: 0.2s; font-weight: 500; font-size: 14px; white-space: nowrap; overflow: hidden; }
        .menu-item:hover { background-color: var(--border-color); color: var(--text-dark); }
        .menu-item.active { background-color: #ECFDF5; color: var(--finance-green); font-weight: 600; }
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }

        /* --- MAIN CONTENT --- */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; width: calc(100% - var(--sidebar-width)); transition: width 0.3s ease; }
        .sidebar.collapsed ~ .main-content { width: calc(100% - var(--sidebar-collapsed-width)); }
        .top-navbar { height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; z-index: 10; }
        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; }
        .nav-right { display: flex; align-items: center; gap: 25px; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: uppercase; }
        .user-avatar { font-size: 32px; color: var(--finance-green); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- DASHBOARD CARDS --- */
        .stat-card { background: white; border-radius: 16px; padding: 25px; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 20px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); height: 100%; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .stat-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .icon-blue { background: #EFF6FF; color: #2563EB; }
        .icon-green { background: #ECFDF5; color: #10B981; }
        
        .stat-info h3 { margin: 0; font-weight: 700; color: var(--text-dark); font-size: 28px; }
        .stat-info p { margin: 0; color: var(--text-gray); font-size: 13px; font-weight: 600; }

        /* --- ACTION BANNER --- */
        .action-banner { background: var(--finance-green); border-radius: 16px; padding: 30px; color: white; display: flex; justify-content: space-between; align-items: center; margin-top: 30px; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }
        .btn-banner { background: white; color: var(--finance-green); border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; text-decoration: none; transition: 0.2s; }
        .btn-banner:hover { background: #F8FAFC; transform: translateY(-2px); color: var(--finance-green); }

        /* --- TABLE RECENT --- */
        .table-card { background: white; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden; margin-top: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table-header { padding: 20px 25px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .table th { background: #FAFAFA; padding: 15px 25px; font-size: 12px; text-transform: uppercase; color: var(--text-gray); border-bottom: 1px solid var(--border-color); }
        .table td { padding: 18px 25px; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #F1F5F9; }
        .badge-finance { background: #EFF6FF; color: #2563EB; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 12px; }

        /* Responsive Overlay */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content { width: 100%; }
            .content-area { padding: 20px; }
            .action-banner { flex-direction: column; text-align: center; gap: 20px; }
            .user-role { display: none; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('finance.dashboard') }}" class="menu-item active"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('approvals.index') }}" class="menu-item"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Daftar Persetujuan</span></a></li>
                <li><a href="#" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Pencairan</span></a></li>
                <li><a href="#" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
                <a href="#" class="menu-item" style="color: var(--text-gray);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right-from-bracket menu-icon"></i><span class="menu-text">Keluar</span>
                </a>
            </div>
        </aside>

        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                    <h5 class="fw-bold m-0 ms-3 d-none d-md-block">Beranda Keuangan</h5>
                </div>
                <div class="nav-right">
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name }}</p>
                            <p class="user-role">{{ Auth::user()->role }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon icon-blue"><i class="fas fa-file-invoice-dollar"></i></div>
                            <div class="stat-info">
                                <h3>{{ $pendingL2 }}</h3>
                                <p>Menunggu Pencairan Anda (Tahap 2)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon icon-green"><i class="fas fa-check-circle"></i></div>
                            <div class="stat-info">
                                <h3>{{ $totalApproved }}</h3>
                                <p>Total SPPD Telah Disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-banner">
                    <div>
                        <h4 class="fw-bold mb-1">Tindakan Pencairan Diperlukan!</h4>
                        <p class="m-0 opacity-75">Ada {{ $pendingL2 }} pengajuan yang sudah lolos tahap Manajer dan menunggu persetujuan dana dari Anda.</p>
                    </div>
                    <a href="{{ route('approvals.index') }}" class="btn-banner">Proses Sekarang <i class="fas fa-arrow-right ms-2"></i></a>
                </div>

                <div class="table-card">
                    <div class="table-header">
                        <h5 class="fw-bold m-0">SPPD Terbaru Menunggu Pencairan</h5>
                        <a href="{{ route('approvals.index') }}" class="text-decoration-none small fw-600" style="color: var(--finance-green);">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Pemohon</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Status Berkas</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRequests as $req)
                                <tr>
                                    <td><span class="fw-bold text-dark">{{ $req->user->name }}</span></td>
                                    <td>{{ $req->destination }}</td>
                                    <td>{{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }}</td>
                                    <td><span class="badge-finance">Menunggu Finance</span></td>
                                    <td class="text-end">
                                        <a href="{{ route('approvals.index') }}" class="btn btn-sm btn-outline-success px-3 fw-600" style="border-radius: 8px;">Periksa</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-wallet fa-2x mb-3 d-block opacity-50"></i>
                                        Tidak ada pengajuan yang perlu dicairkan saat ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            if (window.innerWidth <= 768) { sidebar.classList.toggle('mobile-active'); overlay.classList.toggle('active'); } 
            else { sidebar.classList.toggle('collapsed'); }
        });

        overlay.addEventListener('click', () => { sidebar.classList.remove('mobile-active'); overlay.classList.remove('active'); });
    </script>
</body>
</html>