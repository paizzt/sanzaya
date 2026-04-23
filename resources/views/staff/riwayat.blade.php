<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - Satu Sanzaya</title>
    
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
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); font-weight: 600; }
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }
        .btn-create-nav { background-color: var(--primary-blue); color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; text-decoration: none; }
        .btn-create-nav:hover { background-color: #08427b; color: white; }

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
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: uppercase; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- HISTORY CARDS --- */
        .page-title { font-weight: 700; font-size: 24px; color: var(--text-dark); margin-bottom: 30px; }
        .history-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); padding: 25px; margin-bottom: 20px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .history-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        
        .info-label { font-size: 11px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; margin-bottom: 4px; }
        .info-value { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 0; }
        
        /* Status Badges */
        .status-badge { padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; border: 1px solid transparent; }
        .bg-pending-l1 { background: #FFFBEB; color: #D97706; border-color: #FDE68A; }
        .bg-pending-l2 { background: #EFF6FF; color: #2563EB; border-color: #BFDBFE; }
        .bg-approved { background: #ECFDF5; color: #10B981; border-color: #A7F3D0; }
        .bg-rejected { background: #FEF2F2; color: #EF4444; border-color: #FECACA; }

        /* Action Buttons */
        .btn-note { background: white; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-dark); padding: 8px 12px; font-size: 12px; font-weight: 600; transition: 0.2s; }
        .btn-note:hover { background: #F8FAFC; border-color: #94A3B8; }
        
        .btn-pdf { background: #10B981; color: white; border: none; border-radius: 8px; padding: 8px 12px; font-size: 12px; font-weight: 600; text-decoration: none; transition: 0.2s; display: inline-block; text-align: center; }
        .btn-pdf:hover { background: #059669; color: white; transform: translateY(-2px); }

        /* Modal Style */
        .note-box { background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 10px; padding: 15px; margin-bottom: 15px; }
        .note-box h6 { font-size: 12px; font-weight: 700; color: var(--primary-blue); margin-bottom: 8px; text-transform: uppercase; }
        .note-box p { font-size: 13px; color: #475569; margin-bottom: 0; font-style: italic; }

        /* --- RESPONSIVE --- */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content { width: 100%; }
            .content-area { padding: 20px; }
            .history-card .row > div { margin-bottom: 15px; }
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
                <li><a href="{{ route('staff.dashboard') }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('staff.riwayat') }}" class="menu-item active"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
                <li><a href="{{ route('staff.pengajuan.create') }}" class="menu-item"><i class="fas fa-file-lines menu-icon"></i><span class="menu-text">Pengajuan SPPD</span></a></li>
                <li><a href="{{ route('staff.settings') }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
                <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right-from-bracket menu-icon"></i><span class="menu-text">Keluar</span>
                </a>
                <a href="{{ route('staff.pengajuan.create') }}" class="btn-create-nav mt-3">
                    <i class="fas fa-plus"></i><span class="menu-text">Buat Pengajuan</span>
                </a>
            </div>
        </aside>

        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                    <h5 class="fw-bold m-0 ms-3 d-none d-md-block">Panel Riwayat</h5>
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
                <h1 class="page-title">Riwayat Pengajuan Anda</h1>

                @forelse($requests as $req)
                <div class="history-card">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <p class="info-label">Kota Tujuan</p>
                            <p class="info-value"><i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $req->destination }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="info-label">Tanggal Pelaksanaan</p>
                            <p class="info-value"><i class="far fa-calendar-alt text-primary me-2"></i> {{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="info-label">Status Terkini</p>
                            @if($req->status == 'pending_l1')
                                <span class="status-badge bg-pending-l1"><i class="fas fa-hourglass-half"></i> Menunggu Manajer</span>
                            @elseif($req->status == 'pending_l2')
                                <span class="status-badge bg-pending-l2"><i class="fas fa-hourglass-half"></i> Menunggu Finance</span>
                            @elseif($req->status == 'approved')
                                <span class="status-badge bg-approved"><i class="fas fa-check-circle"></i> Selesai (Disetujui)</span>
                            @elseif($req->status == 'rejected')
                                <span class="status-badge bg-rejected"><i class="fas fa-times-circle"></i> Pengajuan Ditolak</span>
                            @endif
                        </div>
                        <div class="col-md-3 text-md-end">
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('staff.pengajuan.track', $req->id) }}" class="btn-note text-decoration-none text-center">
                                    <i class="fas fa-search-location me-1"></i> Lacak Status
                                </a>
                                
                                @if($req->status == 'approved')
                                    <a href="{{ route('staff.pengajuan.pdf', $req->id) }}" class="btn-pdf">
                                        <i class="fas fa-file-pdf me-1"></i> Unduh SPPD (PDF)
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="noteModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 12px; border: none;">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Detail Pengajuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="note-box">
                                    <h6>Maksud Perjalanan:</h6>
                                    <p class="fst-normal text-dark">"{{ $req->purpose }}"</p>
                                </div>

                                <div class="note-box">
                                    <h6>Catatan Manajer (L1):</h6>
                                    <p>{{ $req->l1_note ?? 'Belum ada catatan dari Manajer.' }}</p>
                                </div>

                                <div class="note-box mb-0">
                                    <h6>Catatan Finance (L2):</h6>
                                    <p>{{ $req->l2_note ?? 'Belum ada catatan dari Keuangan.' }}</p>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary w-100 fw-bold" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5" style="background: white; border-radius: 12px; border: 1px dashed var(--border-color);">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                    <h5 class="fw-bold text-dark">Belum Ada Riwayat</h5>
                    <p class="text-muted">Semua pengajuan SPPD Anda akan muncul di halaman ini.</p>
                </div>
                @endforelse

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