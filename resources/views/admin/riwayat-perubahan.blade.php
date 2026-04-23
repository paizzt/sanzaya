<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perubahan - Admin Satu Sanzaya</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0A539B;
            --light-blue: #E5F0FF;
            --sidebar-bg: #FAFAFA;
            --text-dark: #334155;
            --text-gray: #64748B;
            --border-color: #E2E8F0;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px; 
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
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); font-weight: 600;}
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }

        /* --- MAIN CONTENT --- */
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
        .content-area { padding: 40px; flex-grow: 1; overflow-y: auto; }
        
        /* --- CONTENT STYLING --- */
        .filter-card { background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .form-label-custom { font-size: 12px; font-weight: 700; color: var(--text-gray); text-transform: uppercase; margin-bottom: 8px; display: block; }
        .input-custom { border-radius: 10px; border: 1px solid var(--border-color); padding: 10px 15px; font-size: 14px; width: 100%; outline: none; transition: 0.2s; }
        .input-custom:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); }

        .log-table-card { background: white; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.02); }
        .table thead th { background: #F8FAFC; border-bottom: 1px solid var(--border-color); color: var(--text-gray); font-size: 12px; font-weight: 700; text-transform: uppercase; padding: 15px 20px; }
        .table tbody td { padding: 18px 20px; vertical-align: middle; border-bottom: 1px solid #F1F5F9; font-size: 14px; }

        .user-pill { display: inline-flex; align-items: center; gap: 8px; background: var(--light-blue); color: var(--primary-blue); padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 13px; text-transform: capitalize; }
        .time-text { color: var(--text-gray); font-size: 12px; }
        .activity-text { font-weight: 600; color: var(--text-dark); display: block; }
        .desc-text { color: var(--text-gray); font-size: 13px; margin-top: 2px; }

        .btn-filter { background: var(--primary-blue); color: white; border: none; padding: 10px 25px; border-radius: 10px; font-weight: 600; transition: 0.3s; }
        .btn-filter:hover { background: #08427b; transform: translateY(-2px); }
        .btn-reset { background: white; border: 1px solid var(--border-color); color: var(--text-gray); padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.2s; display: inline-block; }
        .btn-reset:hover { background: #F1F5F9; color: var(--text-dark); }

        /* Responsive */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content, .sidebar.collapsed ~ .main-content { width: 100%; }
            .top-navbar { padding: 0 20px; }
            .content-area { padding: 20px; }
            .user-role { display: none; }
            .filter-card .col-md-4 { margin-top: 15px; }
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
                <li><a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item active"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Perubahan</span></a></li>
                <li><a href="{{ route('admin.kelola.data') ?? '#' }}" class="menu-item"><i class="fas fa-users menu-icon"></i><span class="menu-text">Kelola data</span></a></li>
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
                            <p class="user-role">{{ Auth::user()->role ?? 'admin' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h4 class="fw-bold text-dark m-0">Riwayat Perubahan Sistem</h4>
                    <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 13px;">Total: {{ isset($logs) ? $logs->total() : 0 }} Aktivitas</span>
                </div>

                <div class="filter-card">
                    <form action="{{ route('admin.riwayat.perubahan') ?? '#' }}" method="GET">
                        <div class="row align-items-end g-3">
                            <div class="col-md-3">
                                <label class="form-label-custom">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="input-custom" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="input-custom" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-5">
                                <button type="submit" class="btn-filter"><i class="fas fa-filter me-2"></i> Terapkan Filter</button>
                                <a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="btn-reset ms-2">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="log-table-card table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Pelaku (Role)</th>
                                <th>Aktivitas</th>
                                <th>Keterangan Lengkap</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($logs) && $logs->count() > 0)
                                @foreach($logs as $log)
                                <tr>
                                    <td width="180">
                                        <span class="activity-text">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}</span>
                                        <span class="time-text">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WITA</span>
                                    </td>
                                    <td width="220">
                                        <span class="user-pill">
                                            <i class="fas fa-user-circle"></i> {{ $log->user->name ?? 'User Terhapus' }}
                                            <small class="ms-1 fw-normal text-muted">({{ $log->user->role ?? '-' }})</small>
                                        </span>
                                    </td>
                                    <td width="200">
                                        <span class="badge bg-light text-dark border p-2 fw-600" style="font-size: 12px; border-radius: 8px;">
                                            {{ $log->activity }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="desc-text mb-0">{{ $log->description }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-history fa-3x mb-3 d-block" style="opacity: 0.5;"></i>
                                        <h6 class="fw-bold">Belum Ada Aktivitas</h6>
                                        <p class="mb-0">Belum ada riwayat aktivitas yang tercatat di sistem.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(isset($logs))
                <div class="mt-4 d-flex justify-content-end">
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- LOGIKA SIDEBAR ---
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