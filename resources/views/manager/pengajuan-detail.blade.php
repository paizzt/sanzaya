<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan UC Manajer - Satu Sanzaya</title>
    
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

        /* --- STYLING DETAIL --- */
        .detail-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 35px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .section-title { font-size: 15px; font-weight: 700; color: var(--primary-blue); margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        
        .info-group { margin-bottom: 20px; }
        .info-label { font-size: 12px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
        .info-value { font-size: 15px; font-weight: 600; color: var(--text-dark); background-color: #F8FAFC; padding: 12px 16px; border-radius: 10px; border: 1px solid #E2E8F0; }

        .btn-back { display: inline-flex; align-items: center; gap: 8px; color: var(--text-gray); font-weight: 600; text-decoration: none; margin-bottom: 20px; transition: 0.2s; }
        .btn-back:hover { color: var(--primary-blue); }

        /* --- STEPPER TRACKING --- */
        .stepper-wrapper { display: flex; justify-content: space-between; margin-bottom: 40px; margin-top: 20px; position: relative; }
        .stepper-item { position: relative; display: flex; flex-direction: column; align-items: center; flex: 1; z-index: 1; }
        .stepper-item::before { position: absolute; content: ""; border-bottom: 3px solid #E2E8F0; width: 100%; top: 20px; left: -50%; z-index: -1; }
        .stepper-item:first-child::before { content: none; }
        
        .step-counter { position: relative; z-index: 5; display: flex; justify-content: center; align-items: center; width: 45px; height: 45px; border-radius: 50%; background: #E2E8F0; color: #64748B; font-weight: bold; margin-bottom: 10px; border: 3px solid white; transition: all 0.3s ease; }
        .step-name { font-size: 13px; font-weight: 600; color: #64748B; text-align: center; }
        
        .stepper-item.completed .step-counter { background-color: #10B981; color: white; }
        .stepper-item.completed .step-name { color: #10B981; }
        .stepper-item.completed::before { border-bottom-color: #10B981; }
        
        .stepper-item.active .step-counter { background-color: var(--primary-blue); color: white; box-shadow: 0 0 0 4px rgba(10,83,155,0.2); }
        .stepper-item.active .step-name { color: var(--primary-blue); }
        .stepper-item.active::before { border-bottom-color: #10B981; } /* Garis sebelumnya hijau */

        .stepper-item.rejected .step-counter { background-color: #EF4444; color: white; box-shadow: 0 0 0 4px rgba(239,68,68,0.2); }
        .stepper-item.rejected .step-name { color: #EF4444; }

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
            .step-name { font-size: 11px; }
        }
    </style>
</head>
<body>

    @php
        // Mengambil data pengajuan (fallback jika tidak dikirim dari controller)
        if(!isset($pengajuan)) {
            // Ambil pengajuan terakhir dari manajer yang login
            $pengajuan = \App\Models\TravelRequest::where('user_id', Auth::id())->latest()->first();
        }
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR MANAGER -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('manager.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Persetujuan UC</span></a></li>
                <li><a href="{{ route('manager.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Proses</span></a></li>
                <li><a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item"><i class="fas fa-paper-plane menu-icon"></i><span class="menu-text">Buat Pengajuan</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Detail Pengajuan Saya</h5>
                </div>
                <div class="nav-right">
                    <div class="nav-icon"><i class="far fa-bell"></i><div class="badge-dot"></div></div>
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
                
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('manager.history') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                @if(!$pengajuan)
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                        <div>
                            <strong>Tidak Ada Data!</strong><br>
                            Anda belum membuat pengajuan perjalanan dinas (UC) apa pun.
                        </div>
                    </div>
                @else

                <!-- STATUS TRACKER -->
                <div class="detail-card mb-4 pb-4">
                    <h5 class="fw-bold mb-4 text-center">Status Pengajuan Anda</h5>
                    
                    <div class="stepper-wrapper">
                        <!-- Step 1: Dibuat -->
                        <div class="stepper-item completed">
                            <div class="step-counter"><i class="fas fa-check"></i></div>
                            <div class="step-name">Dikirim</div>
                        </div>
                        
                        <!-- Step 2: L1 (Auto Bypass untuk Manajer) -->
                        <div class="stepper-item completed">
                            <div class="step-counter"><i class="fas fa-forward"></i></div>
                            <div class="step-name">Bypass (L1)</div>
                        </div>

                        <!-- Step 3: Finance (L2) -->
                        <div class="stepper-item 
                            {{ $pengajuan->status === 'approved' ? 'completed' : '' }} 
                            {{ $pengajuan->status === 'pending_l2' ? 'active' : '' }}
                            {{ $pengajuan->status === 'rejected' ? 'rejected' : '' }}">
                            <div class="step-counter">
                                @if($pengajuan->status === 'approved') <i class="fas fa-check"></i>
                                @elseif($pengajuan->status === 'rejected') <i class="fas fa-times"></i>
                                @else 3 @endif
                            </div>
                            <div class="step-name">Finance (L2)</div>
                        </div>

                        <!-- Step 4: Selesai -->
                        <div class="stepper-item {{ $pengajuan->status === 'approved' ? 'completed' : '' }}">
                            <div class="step-counter">
                                @if($pengajuan->status === 'approved') <i class="fas fa-flag-checkered"></i>
                                @else 4 @endif
                            </div>
                            <div class="step-name">Selesai</div>
                        </div>
                    </div>

                    @if($pengajuan->status === 'rejected')
                        <div class="alert alert-danger mt-4 border-0" style="background-color: #FEF2F2; color: #B91C1C;">
                            <strong><i class="fas fa-times-circle me-2"></i> Pengajuan Ditolak</strong><br>
                            Alasan: "{{ $pengajuan->l2_note ?? $pengajuan->l1_note ?? 'Tidak ada catatan khusus.' }}"
                        </div>
                    @elseif($pengajuan->status === 'approved')
                        <div class="alert alert-success mt-4 border-0" style="background-color: #ECFDF5; color: #047857;">
                            <strong><i class="fas fa-check-circle me-2"></i> Pengajuan Berhasil Disetujui!</strong><br>
                            Dana perjalanan dinas Anda siap dicairkan oleh bagian Finance.
                        </div>
                    @endif
                </div>

                <!-- DETAIL PENGAJUAN -->
                <div class="detail-card">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div>
                            <h4 class="fw-bold mb-1">Pengajuan Perjalanan Dinas (UC)</h4>
                            <p class="text-muted small m-0">Tgl Dibuat: {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d F Y, H:i') }} WITA</p>
                        </div>
                    </div>

                    <div class="section-title"><i class="fas fa-map-marked-alt"></i> Rute & Jadwal</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="info-label">Rute Perjalanan</div>
                                <div class="info-value text-primary">
                                    {{ $pengajuan->departure }} <i class="fas fa-arrow-right mx-2 text-muted"></i> {{ $pengajuan->destination }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="info-label">Tanggal Pelaksanaan</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($pengajuan->start_date)->format('d M Y') }} s.d {{ \Carbon\Carbon::parse($pengajuan->end_date)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-title"><i class="fas fa-users"></i> Tim & Operasional</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="info-label">Transportasi yang Digunakan</div>
                                <div class="info-value">
                                    @if($pengajuan->transportation_type == 'Darat')
                                        <i class="fas fa-car text-muted me-2"></i> Darat 
                                        @if($pengajuan->vehicle_number)
                                            <span class="badge bg-secondary ms-2">{{ $pengajuan->vehicle_number }}</span>
                                        @endif
                                    @elseif($pengajuan->transportation_type == 'Udara')
                                        <i class="fas fa-plane text-muted me-2"></i> Udara
                                    @else
                                        <i class="fas fa-ship text-muted me-2"></i> Laut
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="info-label">Pendamping</div>
                                <div class="info-value">
                                    @if($pengajuan->companion_1 || $pengajuan->companion_2)
                                        <ul class="mb-0 ps-3">
                                            @if($pengajuan->companion_1) <li>{{ $pengajuan->companion_1 }}</li> @endif
                                            @if($pengajuan->companion_2) <li>{{ $pengajuan->companion_2 }}</li> @endif
                                        </ul>
                                    @else
                                        <span class="text-muted fst-italic">Berangkat sendiri (Tidak ada)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Download PDF jika sudah Approved -->
                    @if($pengajuan->status === 'approved')
                    <div class="mt-5 text-end border-top pt-4">
                        <a href="{{ route('pengajuan.cetak', $pengajuan->id) }}" target="_blank" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 12px 25px;">
                            <i class="fas fa-file-pdf me-2"></i> Unduh PDF Dokumen
                        </a>
                    </div>
                    @endif

                </div>

                @endif

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