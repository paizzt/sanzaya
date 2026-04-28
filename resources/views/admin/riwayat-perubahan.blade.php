<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Perubahan Sistem - Satu Sanzaya</title>
    
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

        /* --- STYLING HALAMAN RIWAYAT --- */
        .filter-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); padding: 20px; margin-bottom: 20px; }
        .table-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table th { font-weight: 600; font-size: 12px; color: var(--text-gray); text-transform: uppercase; padding: 15px 20px; background-color: #FAFAFA; border-bottom: 1px solid var(--border-color); letter-spacing: 0.5px; }
        .table td { padding: 15px 20px; vertical-align: middle; font-size: 14px; color: var(--text-dark); border-bottom: 1px dashed var(--border-color); }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background-color: #F8FBFF; }

        /* Badge Aktivitas */
        .log-badge { padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        .log-create { background-color: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; }
        .log-update { background-color: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
        .log-delete { background-color: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .log-approve { background-color: #F5F3FF; color: #9333EA; border: 1px solid #E9D5FF; }
        .log-login { background-color: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; }
        .log-default { background-color: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; }

        .time-box { display: flex; flex-direction: column; }
        .time-date { font-weight: 600; color: var(--text-dark); font-size: 13px; }
        .time-hour { font-size: 11px; color: var(--text-gray); }

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

    <!-- MENGAMBIL DATA LOG AKTIVITAS (Jika Model ActivityLog Tersedia) -->
    @php
        $logs = collect();
        // Cek apakah model ActivityLog ada di sistem, jika ada tarik datanya
        if(class_exists('\App\Models\ActivityLog')) {
            $logs = \App\Models\ActivityLog::with('user')->latest()->take(50)->get();
        }
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('admin.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <!-- Menu Riwayat Perubahan menjadi Active -->
                <li><a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item active"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Perubahan</span></a></li>
                <li><a href="{{ route('admin.users.index') ?? '#' }}" class="menu-item"><i class="fas fa-users menu-icon"></i><span class="menu-text">Kelola data</span></a></li>
                <li><a href="{{ route('admin.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Riwayat Aktivitas Sistem</h5>
                </div>
                <div class="nav-right">
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
                
                <div class="filter-card">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Filter Tanggal</label>
                            <div class="input-group">
                                <input type="date" class="form-control">
                                <span class="input-group-text bg-white px-2 border-start-0 border-end-0">-</span>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Jenis Aktivitas</label>
                            <select class="form-select">
                                <option value="">Semua Aktivitas</option>
                                <option value="create">Penambahan Data</option>
                                <option value="update">Perubahan Data</option>
                                <option value="delete">Penghapusan Data</option>
                                <option value="approve">Persetujuan UC</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Cari Keterangan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Ketik kata kunci...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn w-100" style="background: var(--primary-blue); color: white; border-radius: 8px; height: 38px;">
                                <i class="fas fa-filter me-2"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-card table-responsive">
                    <table class="table table-borderless mb-0 align-middle">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Waktu</th>
                                <th style="width: 25%;">Pelaku (Aktor)</th>
                                <th style="width: 15%;">Aktivitas</th>
                                <th style="width: 45%;">Keterangan Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                @php
                                    // Menentukan warna badge berdasarkan action
                                    $action = strtolower($log->action ?? 'default');
                                    $badgeClass = 'log-default';
                                    if(str_contains($action, 'create') || str_contains($action, 'tambah')) $badgeClass = 'log-create';
                                    if(str_contains($action, 'update') || str_contains($action, 'edit')) $badgeClass = 'log-update';
                                    if(str_contains($action, 'delete') || str_contains($action, 'hapus')) $badgeClass = 'log-delete';
                                    if(str_contains($action, 'approve') || str_contains($action, 'setuju')) $badgeClass = 'log-approve';
                                    if(str_contains($action, 'login')) $badgeClass = 'log-login';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="time-box">
                                            <span class="time-date">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}</span>
                                            <span class="time-hour">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }} WITA</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user text-secondary" style="font-size: 12px;"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-bold" style="font-size: 13px;">{{ $log->user->name ?? 'Sistem Otomatis' }}</p>
                                                <p class="mb-0 text-muted" style="font-size: 11px; text-transform: capitalize;">{{ $log->user->role ?? 'System' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="log-badge {{ $badgeClass }}">{{ $log->action ?? 'Aktivitas' }}</span>
                                    </td>
                                    <td>
                                        <p class="m-0 text-dark" style="font-size: 13px;">{{ $log->description ?? '-' }}</p>
                                    </td>
                                </tr>
                            @empty
                                <!-- Tampilan Kosong Jika Tidak Ada Log -->
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="fas fa-history fa-3x mb-3" style="color: #CBD5E1;"></i>
                                        <h6 class="fw-bold text-muted mb-1">Belum Ada Riwayat Perubahan</h6>
                                        <p class="text-muted small mb-0">Semua aktivitas pengguna seperti login, penambahan data, dan perubahan akan tercatat di sini.</p>
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