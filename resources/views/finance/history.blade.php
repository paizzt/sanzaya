<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pencairan L2 - Satu Sanzaya</title>
    
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

        /* --- MAIN CONTENT & NAVBAR KONSISTEN --- */
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

        /* --- STYLING TABEL RIWAYAT --- */
        .filter-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); padding: 20px; margin-bottom: 20px; }
        .table-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table th { font-weight: 600; font-size: 12px; color: var(--text-gray); text-transform: uppercase; padding: 15px 20px; background-color: #FAFAFA; border-bottom: 1px solid var(--border-color); }
        .table td { padding: 15px 20px; vertical-align: middle; font-size: 14px; color: var(--text-dark); border-bottom: 1px dashed var(--border-color); }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background-color: #F8FBFF; }
        
        .status-pill { padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; }
        .bg-success-light { background: #ECFDF5; color: #10B981; border: 1px solid #A7F3D0; }
        .bg-danger-light { background: #FEF2F2; color: #EF4444; border: 1px solid #FECACA; }
        .bg-info-light { background: #EFF6FF; color: #3B82F6; border: 1px solid #BFDBFE; }

        .user-info-name { font-weight: 600; color: var(--text-dark); margin: 0; font-size: 13px; }
        .user-info-sub { font-size: 11px; color: var(--text-gray); margin: 0; }

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

    <!-- MENGAMBIL DATA RIWAYAT OTOMATIS -->
    @php
        if(!isset($requests)) {
            // Finance (L2) melihat semua request yang l2_approver_id nya adalah ID mereka
            $requests = \App\Models\TravelRequest::with('user')
                ->where('l2_approver_id', Auth::id())
                ->orderBy('updated_at', 'desc')
                ->get();
        }
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR FINANCE -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('finance.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('finance.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-invoice-dollar menu-icon"></i><span class="menu-text">Antrean Pencairan</span></a></li>
                <li><a href="{{ route('finance.history') ?? '#' }}" class="menu-item active"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Pencairan</span></a></li>
                <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                <li><a href="{{ route('finance.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="fw-bold m-0 ms-3 d-none d-md-block">Riwayat Keputusan Pencairan</h5>
                </div>
                <div class="nav-right">
                    <div class="nav-icon"><i class="far fa-bell"></i><div class="badge-dot"></div></div>
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama Finance' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'finance' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <h5 class="fw-bold mb-4" style="color: var(--text-dark);">Daftar Dokumen yang Pernah Anda Proses (L2)</h5>

                <!-- Filter Box -->
                <div class="filter-card">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Cari Dokumen/Pegawai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Ketik kata kunci...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Filter Status</label>
                            <select class="form-select">
                                <option value="">Semua Riwayat</option>
                                <option value="disetujui">Selesai (Dicairkan)</option>
                                <option value="ditolak">Ditolak</option>
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
                                <th style="width: 20%;">Pegawai</th>
                                <th style="width: 25%;">Rute & Pelaksanaan</th>
                                <th style="width: 20%;">Status Akhir</th>
                                <th style="width: 25%;">Catatan Keuangan (L2)</th>
                                <th style="width: 10%; text-align: center;">Aksi</th>
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
                                        <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($req->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                                    </p>
                                </td>
                                <td>
                                    @if($req->status == 'approved')
                                        <span class="status-pill bg-success-light"><i class="fas fa-check-circle"></i> Selesai (Dicairkan)</span>
                                    @elseif($req->status == 'rejected')
                                        <span class="status-pill bg-danger-light"><i class="fas fa-times-circle"></i> Anda Tolak (L2)</span>
                                    @else
                                        <span class="status-pill bg-info-light"><i class="fas fa-history"></i> {{ $req->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Menampilkan L2 Note -->
                                    @if($req->l2_note)
                                        <p class="mb-0 small text-muted fst-italic" style="line-height: 1.4;">"{{ $req->l2_note }}"</p>
                                    @else
                                        <span class="text-muted small fst-italic">Tanpa catatan.</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('approvals.show', $req->id) }}" class="btn btn-sm btn-light border fw-bold text-primary px-3 rounded-pill" style="font-size: 12px; transition: 0.2s;">
                                        <i class="fas fa-search me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3" style="color: #CBD5E1;"></i>
                                    <p class="fw-bold text-dark mb-1">Belum Ada Riwayat</p>
                                    <p class="small">Anda belum melakukan tindakan (Cairkan/Tolak) pada pengajuan UC manapun.</p>
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