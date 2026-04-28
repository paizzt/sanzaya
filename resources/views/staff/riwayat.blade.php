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

        /* Badge Status */
        .status-pill { padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; }
        .bg-success-light { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
        .bg-warning-light { background: #FFFBEB; color: #B45309; border: 1px solid #FDE68A; }
        .bg-info-light { background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE; }
        .bg-danger-light { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }

        .btn-pdf { background-color: #EF4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn-pdf:hover { background-color: #DC2626; color: white; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2); }
        .btn-pdf.disabled { background-color: #E2E8F0; color: #94A3B8; cursor: not-allowed; box-shadow: none; transform: none; }

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

    <!-- MENGAMBIL DATA RIWAYAT PRIBADI STAFF LANGSUNG -->
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        $riwayat = \App\Models\TravelRequest::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();
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
                <li><a href="{{ route('staff.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <!-- Menu Riwayat Pengajuan menjadi Active -->
                <li><a href="{{ route('staff.riwayat') ?? '#' }}" class="menu-item active"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Riwayat Pengajuan UC</h5>
                </div>
                <div class="nav-right">
                    <div class="nav-icon"><i class="far fa-bell"></i><div class="badge-dot"></div></div>
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
                
                <!-- Filter Card -->
                <div class="filter-card">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Cari Tujuan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Ketik kota tujuan...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Filter Status</label>
                            <select class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending_l1">Menunggu Manajer</option>
                                <option value="pending_l2">Menunggu Finance</option>
                                <option value="approved">Selesai / Approved</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-uppercase text-muted fw-bold" style="font-size: 11px;">Urutkan</label>
                            <select class="form-select">
                                <option value="terbaru">Terbaru Diajukan</option>
                                <option value="terlama">Paling Lama</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="btn w-100" style="background: var(--primary-blue); color: white; border-radius: 8px; height: 38px; font-size: 13px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-plus"></i> Buat Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card table-responsive">
                    <table class="table table-borderless mb-0 align-middle">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Tujuan & Durasi</th>
                                <th style="width: 15%;">Tgl Pengajuan</th>
                                <th style="width: 20%;">Status Saat Ini</th>
                                <th style="width: 25%;">Catatan Validator</th>
                                <th style="width: 15%; text-align: center;">Aksi Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $req)
                                <tr>
                                    <td>
                                        <p class="mb-0 fw-bold text-dark" style="font-size: 14px;">{{ $req->destination }}</p>
                                        <p class="mb-0 text-muted" style="font-size: 12px;">
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
                                            <span class="status-pill bg-warning-light">
                                                <i class="fas fa-hourglass-half"></i> Menunggu Manajer
                                            </span>
                                        @elseif($req->status == 'pending_l2')
                                            <span class="status-pill bg-info-light">
                                                <i class="fas fa-money-check"></i> Menunggu Finance
                                            </span>
                                        @elseif($req->status == 'approved')
                                            <span class="status-pill bg-success-light">
                                                <i class="fas fa-check-circle"></i> Selesai (Approved)
                                            </span>
                                        @elseif($req->status == 'rejected')
                                            <span class="status-pill bg-danger-light">
                                                <i class="fas fa-times-circle"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->status == 'rejected' || $req->l1_note || $req->l2_note)
                                            <div style="font-size: 12px; line-height: 1.4;">
                                                @if($req->l1_note)
                                                    <span class="text-muted d-block"><strong>Manajer:</strong> "{{ $req->l1_note }}"</span>
                                                @endif
                                                @if($req->l2_note)
                                                    <span class="text-muted d-block mt-1"><strong>Finance:</strong> "{{ $req->l2_note }}"</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic small">Belum ada catatan.</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Logika Cetak PDF: Hanya jika status approved -->
                                        @if($req->status == 'approved')
                                            <!-- Ganti route 'pengajuan.cetak' dengan nama route cetak PDF Anda yang sebenarnya -->
                                            <a href="{{ route('pengajuan.cetak', $req->id) ?? url('/pengajuan/'.$req->id.'/pdf') }}" target="_blank" class="btn-pdf" title="Unduh Surat Pengajuan UC">
                                                <i class="fas fa-file-pdf me-1"></i> Unduh PDF
                                            </a>
                                        @else
                                            <button type="button" class="btn-pdf disabled" title="PDF belum tersedia (Menunggu Persetujuan)" onclick="alertPending()">
                                                <i class="fas fa-file-pdf me-1"></i> Unduh PDF
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-folder-open fa-3x mb-3" style="color: #CBD5E1;"></i>
                                        <h6 class="fw-bold text-dark mb-1">Belum Ada Riwayat</h6>
                                        <p class="text-muted small mb-3">Anda belum pernah mengajukan perjalanan dinas (UC).</p>
                                        <a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="btn btn-sm" style="background: var(--light-blue); color: var(--primary-blue); font-weight: 600; padding: 8px 20px; border-radius: 8px;">
                                            Buat Pengajuan Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    <!-- PENTING: Panggil library SweetAlert2 untuk Popup -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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

        // Peringatan jika menekan tombol PDF yang belum disetujui
        function alertPending() {
            Swal.fire({
                icon: 'info',
                title: 'Dokumen Belum Tersedia',
                text: 'PDF hanya dapat diunduh jika pengajuan Anda telah disetujui (Approved) oleh Manajer dan Finance.',
                confirmButtonColor: '#0A539B'
            });
        }
    </script>
</body>
</html>